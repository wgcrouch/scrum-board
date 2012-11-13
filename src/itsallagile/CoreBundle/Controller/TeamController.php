<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use itsallagile\CoreBundle\Entity\Team;
use itsallagile\CoreBundle\Entity\User;
use itsallagile\CoreBundle\Form\Type\Team\Add;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TeamController extends Controller
{

    public function addAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $request = $this->get('request');

        $team = new Team();
        $form = $this->get('form.factory')->create(new Add(), $team);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $user = $this->get('security.context')->getToken()->getUser();
                $team->setOwner($user);
                $team->setVelocity(0);
                $user->getTeams()->add($team);

                $em->persist($team);
                $em->persist($user);
                $em->flush();

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
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Team');
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

        $user = $this->getDoctrine()->getRepository('itsallagileCoreBundle:User')
            ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id '. $userId);
        }

        if ($admin == $user) {
            throw new AccessDeniedHttpException('You cannot remove an administrator from a team');
        }

        $user->removeTeam($team);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('core_teams_edit', array('teamId' => $team->getTeamId())));
    }
}
