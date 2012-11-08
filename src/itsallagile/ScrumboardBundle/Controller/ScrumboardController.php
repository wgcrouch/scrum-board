<?php

namespace itsallagile\ScrumboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ScrumboardController extends Controller
{
    protected function getBoard($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
            'SELECT b FROM itsallagileCoreBundle:Board b WHERE b.boardId = :slug OR b.slug = :slug'
        )->setParameter('slug', $slug);
        $board = $query->getSingleResult();
        if (!$board) {
            throw $this->createNotFoundException('No board found for slug ' . $slug);
        }
        return $board;
    }

    public function indexAction($slug)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $board = $this->getBoard($slug);

        if (!$user->hasTeam($board->getTeam())) {
            throw new AccessDeniedHttpException('You do not have access to this board');
        }

        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Status');
        $statusArray = array();
        $statuses = $repository->findAll();
        foreach ($statuses as $status) {
            $statusArray[] = $status->getArray();
        }

        $viewData = array('board' => $board->getArray(), 'statuses' => $statusArray);

        return $this->render('itsallagileScrumboardBundle:Board:index.html.twig', $viewData);
    }
}
