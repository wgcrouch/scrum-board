<?php

namespace Itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Itsallagile\CoreBundle\Document\Team;
use Itsallagile\CoreBundle\Document\User;
use Itsallagile\CoreBundle\Form\Type\Team\Add;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

                $dm->persist($team);
                $dm->persist($user);
                $dm->flush();

                return $this->redirect($this->generateUrl('core_dashboard'));
            }
        }

        return $this->render('ItsallagileCoreBundle:Team:add.html.twig', array('form' => $form->createView()));
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
     * Show the edit screen to manage team members
     *
     */
    public function editAction(Team $team)
    {
        $this->checkAdmin($team);

        return $this->render('ItsallagileCoreBundle:Team:edit.html.twig', array('team' => $team));
    }

    /**
     * Remove a user from a team
     * @ParamConverter("team", class="Itsallagile\CoreBundle\Document\Team", options={"id" = "id_team"})
     * @ParamConverter("user", class="Itsallagile\CoreBundle\Document\User", options={"id" = "id_user"})
     */
    public function removeUserAction(Team $team, User $user)
    {
        $this->checkAdmin($team);

        $admin = $this->get('security.context')->getToken()->getUser();

        if ($admin == $user) {
            throw new AccessDeniedHttpException('You cannot remove an administrator from a team');
        }

        $team->removeUser($user);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($team);
        $dm->flush();

        return $this->redirect($this->generateUrl('core_teams_edit', array('id' => $team->getId())));
    }
}
