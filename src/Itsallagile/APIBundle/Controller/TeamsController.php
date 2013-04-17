<?php

namespace Itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Itsallagile\CoreBundle\Document\Team;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Itsallagile\APIBundle\Form\TeamType;

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

    /**
     * Add a new Team
     * @param  Request $request
     */
    public function postTeamsAction(Request $request)
    {
        $view = View::create();
        $team = new Team();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new TeamType(), $team);
        $form->bind($request);

        if ($form->isValid()) {
            $team->setOwner($user);
            $team->addUser($user);
            $team->setVelocity(0);
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($team);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($team);
        } else {
            $view->setData($form);
        }
        return $view;
    }
}
