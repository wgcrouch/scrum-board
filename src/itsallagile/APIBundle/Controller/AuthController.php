<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Used to check if a user is logged in from JS
 */
class AuthController extends FOSRestController implements ApiController
{

    public function getAuthAction()
    {
        return array('loggedIn' => true);
    }
}
