<?php

namespace itsallagile\ScrumboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BoardController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('itsallagileScrumboardBundle:Board:index.html.twig');
    }
}
