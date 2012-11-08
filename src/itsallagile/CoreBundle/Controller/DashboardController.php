<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{

    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
            '
              SELECT b
              FROM itsallagileCoreBundle:Board b
              WHERE b.team IN
                (SELECT t.teamId FROM itsallagileCoreBundle:Team t WHERE :userId MEMBER OF t.users)
            '
        )->setParameter('userId', $user->getUserId());

        $boards = $query->getResult();

        return $this->render('itsallagileCoreBundle:Dashboard:index.html.twig', array('boards' => $boards));
    }
}
