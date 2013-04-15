<?php

namespace Itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Itsallagile\CoreBundle\Document\Team;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TeamsController extends FOSRestController implements ApiController
{
    /**
     * Get a single Team
     */
    public function getTeamAction(Team $team)
    {
        return $team;
    }

    /**
     * Get all teams
     */
    public function getTeamsAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $repository = $this->get('doctrine_mongodb')->getRepository('ItsallagileCoreBundle:Team');
        $data = array();
        $teams = $repository->findAllByUser($user);;

        foreach ($teams as $team) {
            $data[] = $team;
        }

        return $data;
    }
}
