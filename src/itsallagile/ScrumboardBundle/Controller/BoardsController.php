<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Board,
    Symfony\Component\HttpFoundation\Request;

class BoardsController extends RestController
{
    
    /**
     * Get a single Board
     * 
     * @param integer $boardId     
     */
    public function getAction($boardId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        
        $board = $repository->find($boardId);

        if (!$board) {
            throw $this->createNotFoundException('No Board found for id '. $boardId);
        }
        $data = $board->getArray();
     
        return $this->restResponse($data, 201);
        
    }
    
    /**
     * Get all boards     
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        $data = array();
        $boards = $repository->findAll();

        foreach($boards as $board) {
            $data[$board->getBoardId()] = $board->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * Get all boards for a board
     * 
     * @param integer $boardId     
     */
    public function getForBoardAction($boardId)
    {
        
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        
        $board = $repository->find($boardId);
        
        if (!$board) {
            throw $this->createNotFoundException('No board found for id ' . $boardId);
        }
        $data = array();
        $boards = $board->getBoards();

        foreach($boards as $board) {
            $data[$board->getBoardId()] = $board->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * Create a new Board
     * 
     * @param Request $request     
     */
    public function postAction(Request $request)
    {        
        $board = new Board();
        $board->setName($request->get('name'));
        $board->setSlug($request->get('slug'));
        
        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')->find($request->get('boardId'));
        $board->setBoard($board);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($board);  
        $em->flush();       
    
        return $this->restResponse($board->getArray(), 201);
    }
    
    /**
     * Update an existing Board
     * 
     * @param integer $boardId
     * @param Request $request     
     */
    public function putAction($boardId, Request $request)
    {       
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        
        $board = $repo->find($boardId);
        
        if (!$board) {
            throw $this->createNotFoundException('No Board found for id '. $boardId);
        }
        $board->setName($request->get('name'));
        $board->setSlug($request->get('slug'));

        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')->find($request->get('boardId'));
        $board->setBoard($board);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($board);  
        $em->flush();       
    
        return $this->restResponse($board->getArray(), 201);
    }
    
    /**
     * Delete a Board
     * @param integer $boardId
     * @return type     
     */
    public function deleteAction($boardId)
    { 
        
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        
        $board = $repo->find($boardId);
        
        if (!$board) {
            throw $this->createNotFoundException('No Board found for id '. $boardId);
        }
              
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($board);
        $em->flush();
    
        return $this->restResponse(array(), 201);
    }
    
}
