<?php
/**
 * Created by PhpStorm.
 * User: Black_Flex
 * Date: 01.12.2017
 * Time: 19:37
 */

namespace AppBundle\Controller;



use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PageController extends Controller
{
    /**
     * @Route("/{_locale}", name="homepage",
     * requirements={
     *      "_locale": "en|gr"
     *  },
     *  defaults={
     *      "_locale": "en"
     *  }
     * )
     */
    public function indexAction($_locale = "en"){

        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Page");
        $slideRepository = $this->getDoctrine()->getRepository("AppBundle:Slide");
        $testimonialRepository = $this->getDoctrine()->getRepository("AppBundle:Testimonials");
        $partnerRepository = $this->getDoctrine()->getRepository("AppBundle:Partner");
        $statisticsCounterRepository= $this->getDoctrine()->getRepository("AppBundle:StatisticsCounter");
        $statisticsCounter=$statisticsCounterRepository->findBy(
            array(),
            array('counterOrder' => 'ASC')
        );
        $page = $pageRepository->findOneById(1);
        $slides = $slideRepository->findBy(
            array(),
            array('slideOrder' => 'ASC')
        );
        $testimonials = $testimonialRepository->findBy(
            array(),
            array('testimonialOrder' => 'ASC')
        );
        $partners= $partnerRepository->findBy(
            array(),
            array('partnerOrder' => 'ASC')
        );
        $advantageGroup=$page->getAdvantageGroup();
        $advantages =  $advantageGroup->getAdvantage();
        $testimonialPage=$pageRepository->findOneById(14);
        return $this->render('pages/index.html.twig', array(
            'page' => $page,
            'home' => true,
            'slides' => $slides,
            'advantages' => $advantages,
            'advantageGroup' => $advantageGroup,
            'testimonials' => $testimonials,
            'partners' => $partners,
            'statisticsCounter' => $statisticsCounter,
            'testimonialpage' => $testimonialPage
        ));
   }


    /**
     * @Route("/features")
     * @Route("/{_locale}/features", name="page_features",
     *  requirements={
     *      "_locale": "en|gr"
     *  },
     *  defaults={
     *      "_locale": "en"
     *  }
     * )
     */
    public function featuresAction(){

        $featureRepository = $this->getDoctrine()->getRepository("AppBundle:Feature");
        $featureListRepository = $this->getDoctrine()->getRepository("AppBundle:FeatureList");
        $features = $featureRepository->findBy(
            array(),
            array('featureOrder' => 'ASC')
        );

        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Page");
        $page = $pageRepository->findOneById(12);
        $statistics = $pageRepository->findOneById(13);
        $countriesRepository= $this->getDoctrine()->getRepository("AppBundle:Statistics");
        $countries=$countriesRepository->findAll();
        return $this->render('pages/features.html.twig',array(
            'page' => $page,
            'statistics' => $statistics,
            'countries' => $countries,
            'features'=>$features
        ));
    }



    /**
     * @Route("/contact")
     * @Route("/{_locale}/contact", name="page_contact",
     *  requirements={
     *      "_locale": "en|gr"
     *  },
     *  defaults={
     *      "_locale": "en"
     *  }
     * )
     */
    public function contactAction(Request $request){

        $translator = $this->get('translator');

        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Page");
        $page = $pageRepository->findOneById(7);

        $contactRepository = $this->getDoctrine()->getRepository('AppBundle:Contact');
        $contactsQuery = $contactRepository->createQueryBuilder('c')
            ->where('cg.id != :socialId')
            ->join('AppBundle:ContactGroup', 'cg', 'WITH', 'c.contactGroup = cg')
            ->orderBy('c.contactOrder', 'ASC')
            ->orderBy('cg.contactGroupOrder', 'ASC')
            ->setParameter('socialId', 5)
            ->getQuery()
        ;

        $contacts = $contactsQuery->getResult();


        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('save', SubmitType::class, array(
                'label' => $translator->trans('Send Message')
            ))
            ->getForm()
        ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $formData = $form->getData();

            $message = (new \Swift_Message($formData['name']))
                ->setFrom('#')
                ->setTo('#')
                ->setBody(
                    $this->renderView(
                        'email/mail_contact.html.twig',
                        array(
                            'name' => $formData['name'],
                            'email' => $formData['email'],
                            'message' => $formData['message']
                        )
                    ),
                    'text/html'
                )
            ;

            $mailer = $this->get('mailer')->send($message);

            if($mailer == 1){
                $alert="Your Mail is Send !";
            } else {
                $alert="Something went Wrong";
            }

            $this->addFlash(
                'notice',
                $alert
            );

            return $this->redirectToRoute('page_contact');

        }

        return $this->render('pages/contact.html.twig',array(
            'page'=>$page,
            'form' => $form->createView(),
            'contacts'=>$contacts
        ));
    }


}