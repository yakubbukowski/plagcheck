<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/7/2017
 * Time: 11:51 AM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

class UserDocument extends Controller
{

    /**
     * @Route("/checker/retrieve/{docId}", name="retrieve_view")
     */
    public function viewRetrieveAction($docId,Session $session){

        $post_data = array(
            "access_token"=> $session->get('access_token'),
            "mode" => 8
        );
        $docID = $docId;
        $client = new Client([
            "base_uri" => "#",
            "timeout" => 30.0,
            "http_errors" => false
        ]);
        $response = $client->get("documents/".$docID."/retrieve", [ "query" => $post_data]);
        if($response->getStatusCode() == 200){
            $_SESSION['submit']="false";
            $pdfBody = $response->getBody();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/pdf');
            $response->setContent($pdfBody);
            return $response;
        }
        else{
            $this->addFlash(
                'danger',
                'Cant Open The Document'
            );

            return $this->redirectToRoute('plag_checker');
        }

    }

    /**
     * @Route("/checker/delete/{docId}", name="delete_retrieve")
     */
    public function deleteAction($docId){
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository("AppBundle:UserDocument")->findOneBy(
            array('docId'=>$docId)
        );
        $em->remove($document);
        $em->flush();
        return $this->redirectToRoute('plag_checker');
    }


}