<?php

namespace Itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ItsallagileCoreBundle:Home:index.html.twig', array('name' => $name));
    }
}
