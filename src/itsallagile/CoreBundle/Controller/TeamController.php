<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    itsallagile\CoreBundle\Entity\Team,
    itsallagile\CoreBundle\Entity\User,
    itsallagile\CoreBundle\Form\Type\Team\Add,
    Symfony\Component\HttpFoundation\Response;

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
                $team->setOwner($user->getUserId());
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
}
