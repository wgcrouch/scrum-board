<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController,
    itsallagile\CoreBundle\Entity\Board,
    Symfony\Component\HttpFoundation\Request;

class BoardsController extends FOSRestController
{
    
    /**
     * Get a single Board
     * 
     * @param integer $boardId     
     */
    public function getBoardAction($boardId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        
        $board = $repository->find($boardId);

        if (!$board) {
            throw $this->createNotFoundException('No Board found for id '. $boardId);
        }
        $data = $board->getArray();
     
        return $data;
        
    }
    
    /**
     * Get all boards     
     */
    public function getBoardsAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        $data = array();
        $boards = $repository->findAll();

        foreach($boards as $board) {
            $data[$board->getBoardId()] = $board->getArray();
        }
     
        return $data;
    }
            
}
