<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use itsallagile\CoreBundle\Entity\User;

class NavigationController extends Controller
{
    public function renderAction(User $user)
    {
        $config = $this->get('config')->get('navigation');
        
        var_dump($config);exit;
        
        return $this->render('itsallagileCoreBundle:Core:navigation.html.twig', array('name' => $name));
    }
}
