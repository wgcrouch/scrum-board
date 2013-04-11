<?php

namespace Itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $dm = $this->get('doctrine_mongodb')->getManager();

        $teams = $dm->getRepository('ItsallagileCoreBundle:Team')
            ->findAllByUser($user);

        $boards = $dm->getRepository('ItsallagileCoreBundle:Board')
            ->findAllByTeams($teams);

        return $this->render(
            'ItsallagileCoreBundle:Dashboard:index.html.twig',
            array('boards' => $boards, 'teams' => $teams)
        );
    }
}
