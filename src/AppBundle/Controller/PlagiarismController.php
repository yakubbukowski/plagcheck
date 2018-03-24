<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserDocument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\Security\Core\User\UserInterface;

class PlagiarismController extends Controller
{

    /**
     * @Route("/checker/{pageId}",requirements={"pageId"="\d+"})
     * @Route("/{_locale}/checker/{pageId}", name="plag_checker",
     *  requirements={
     *      "_locale": "en|gr",
     *     "pageId"="\d+"
     *  },
     *  defaults={
     *      "_locale": "en"
     *  }
     * )
     */
    public function checkerAction($pageId=1){
        $documents_rep= $this->getDoctrine()->getRepository("AppBundle:UserDocument");
        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Page");
        $page = $pageRepository->findOneById(8);
        $user = $this->getUser();
        $documents=$documents_rep->findBy(
            array('user'=>$user),
            array('id'=>'desc')
        );
        $docCount = count($documents);
        $limit=10;
        if($docCount%$limit==0){
            $docCount=$docCount/$limit;
        }else{
            $docCount=floor($docCount/$limit)+1;
        }
        if($pageId>0)
            $offset= ($pageId-1)*$limit;
        else
            $offset=0;
        $documents=$documents_rep->findBy(
            array('user'=>$user),
            array('id'=>'desc'),$limit,$offset
        );
        return $this->render('plagiarism/checker.html.twig',array(
            'documents'=>$documents,
            'page'=>$page,
            'docCount'=>$docCount
        ));

    }

    /**
     * @Route("/checker/access-token", name="plag_access_token")
     * @Method("POST")
     */
    public function accessTokenAction(Session $session){
        $post_data = array(
            "grant_type" => "#",
            "client_id" => "#",
            "client_secret" => "#"
        );

        $client = new Client([
            "base_uri" => "#",
            "timeout" => 2.0,
            "http_errors" => false
        ]);
        $response = $client->post("token", [ "form_params" => $post_data]);

        if($response->getStatusCode() == 200){
            $content = json_decode($response->getBody(), true);
            ///////////////////session start///////////////////////
            $session->set('access_token', $content["access_token"]);



        }
        return new Response($session->get('access_token'));
    }


    /**
     * @Route("/checker/retrieve", name="plag_retrieve")
     */
    public function retrieveAction(Session $session){



            $post_data = array(
                "access_token"=> $session->get('access_token'),
                "mode" => 8
            );

            $docID = $session->get('docID');

            $client = new Client([
                "base_uri" => "https://api.plagscan.com/v3/",
                "timeout" => 30.0,
                "http_errors" => false
            ]);

            $response = $client->get("documents/".$docID."/retrieve", [ "query" => $post_data]);

            if($response->getStatusCode() == 200){
                $message=json_decode($response->getBody(),true);
                $pdfBody = $response->getBody();
                $file_name="N/A";
                $response = new Response();
                $response->headers->set('Content-Type', 'application/pdf');
                $response->setContent($pdfBody);
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                    $doc= $this->getDoctrine()->getRepository("AppBundle:UserDocument");
                    $check=$doc->findBy(
                        array('docId'=>$docID)
                    );
                    if(empty($check)){
                        $document = new UserDocument();
                        $document->setDocName($file_name);
                        $document->setDocId($docID);
                        $document->setUser($user);
                        $em->persist($document);
                        $em->flush();
                    }
                return $response;
            }
            else{
                $message=json_decode($response->getBody(),true);
                $message_info= $message['error']['message'];

            }

        return new Response($message_info);

    }



}