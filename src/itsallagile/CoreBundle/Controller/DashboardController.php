<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $dm = $this->get('doctrine_mongodb')->getManager();

        $teams = $dm->getRepository('itsallagileCoreBundle:Team')
            ->findAllByUser($user);

        $boards = $dm->getRepository('itsallagileCoreBundle:Board')
            ->findAllByTeams($teams);

        return $this->render(
            'itsallagileCoreBundle:Dashboard:index.html.twig',
            array('boards' => $boards, 'teams' => $teams)
        );
    }
}
