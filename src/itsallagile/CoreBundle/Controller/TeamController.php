<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use itsallagile\CoreBundle\Document\Team;
use itsallagile\CoreBundle\Document\User;
use itsallagile\CoreBundle\Form\Type\Team\Add;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TeamController extends Controller
{

    public function addAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $request = $this->get('request');

        $team = new Team();
        $form = $this->get('form.factory')->create(new Add(), $team);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $user = $this->get('security.context')->getToken()->getUser();
                $team->setOwner($user);
                $team->setVelocity(0);
                $team->addUser($user);
                //$user->getTeams()->add($team);

                $dm->persist($team);
                $dm->persist($user);
                $dm->flush();

                return $this->redirect($this->generateUrl('core_dashboard'));
            }
        }

        return $this->render('itsallagileCoreBundle:Team:add.html.twig', array('form' => $form->createView()));
    }

    /**
     * Check that the current user is allowed to administer this team
     * @param Team $team
     * @throws AccessDeniedHttpException
     */
    protected function checkAdmin(Team $team)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if ($team->getOwner() !== $user) {
            throw new AccessDeniedHttpException('You are not allowed to manage that team');
        }
    }

    /**
     * Try to retrieve a team by an id
     * @param integer $teamId
     * @return Team
     */
    protected function getTeam($teamId)
    {
        $repository = $this->get('doctrine_mongodb')->getRepository('itsallagileCoreBundle:Team');
        $team = $repository->find($teamId);
        if (!$team) {
            throw $this->createNotFoundException('No team found for id '. $teamId);
        }
        return $team;
    }

    /**
     * Show the edit screen to manage team members
     *
     * @param integer $teamId
     */
    public function editAction($teamId)
    {
        $team = $this->getTeam($teamId);
        $this->checkAdmin($team);

        return $this->render('itsallagileCoreBundle:Team:edit.html.twig', array('team' => $team));
    }

    /**
     * Remove a user from a team
     */
    public function removeUserAction($teamId, $userId)
    {
        $team = $this->getTeam($teamId);
        $this->checkAdmin($team);

        $admin = $this->get('security.context')->getToken()->getUser();

        $user = $this->get('doctrine_mongodb')->getRepository('itsallagileCoreBundle:User')
            ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id '. $userId);
        }

        if ($admin == $user) {
            throw new AccessDeniedHttpException('You cannot remove an administrator from a team');
        }

        $team->removeUser($user);
        $dm = $this->$this->get('doctrine_mongodb')->getManager();
        $em->persist($team);
        $em->flush();

        return $this->redirect($this->generateUrl('core_teams_edit', array('teamId' => $team->getTeamId())));
    }
}
