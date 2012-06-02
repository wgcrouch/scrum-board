<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');

        $boards = $repository->findAll();
        
        return $this->render('itsallagileCoreBundle:Dashboard:index.html.twig', array('boards' => $boards));
    }
}
