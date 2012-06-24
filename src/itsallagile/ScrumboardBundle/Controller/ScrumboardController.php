<?php

namespace itsallagile\ScrumboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ScrumboardController extends Controller
{
    
    public function indexAction($slug)
    {
             
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
            'SELECT b FROM itsallagileCoreBundle:Board b WHERE b.boardId = :slug OR b.slug = :slug'
        )->setParameter('slug', $slug);

        $board = $query->getSingleResult();

        if (!$board) {
            throw $this->createNotFoundException('No board found for slug ' . $slug);
        }        
        
        $viewData = array('board' => $board);
        return $this->render('itsallagileScrumboardBundle:Board:index.html.twig', $viewData);
    }
}
