<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PartsController extends Controller
{

    public function footerAboutAction(){

        $pageRepository = $this->getDoctrine()->getRepository("AppBundle:Page");
        $about = $pageRepository->findOneById(2);

        return $this->render('includes/footer_about.html.twig', array(
            'about' => $about
        ));

    }
}