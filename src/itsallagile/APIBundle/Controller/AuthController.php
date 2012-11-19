<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Used to check if a user is logged in from JS
 */
class AuthController extends FOSRestController
{

    public function getAuthAction()
    {
        $view = View::create();
        $view->setData(array('loggedIn' => true));
        return $view;
    }
}
