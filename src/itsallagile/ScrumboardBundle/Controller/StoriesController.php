<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Story,
    Symfony\Component\HttpFoundation\Request;

class StoriesController extends RestController
{
    
    /**
     * Get a single story
     * 
     * @param integer $storyId     
     */
    public function getAction($storyId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        $story = $repository->find($storyId);

        if (!$story) {
            throw $this->createNotFoundException('No story found for id '. $storyId);
        }
        $data = $story->getArray();
     
        return $this->restResponse($data, 201);
        
    }
    
    /**
     * Get all stories     
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        $data = array();
        $stories = $repository->findAll();

        foreach($stories as $story) {
            $data[$story->getStoryId()] = $story->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * Get all stories for a board
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
        $stories = $board->getStories();

        foreach($stories as $story) {
            $data[$story->getStoryId()] = $story->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * Create a new story
     * 
     * @param Request $request     
     */
    public function postAction(Request $request)
    {        
        $story = new Story();
        $story->setContent($this->getParam('content'));

        $story->setSort($this->getParam('sort'));
        $story->setPoints($this->getParam('points'));

        $status = $this->getDoctrine()->getRepository('itsallagileCoreBundle:StoryStatus')
            ->findOneByName('New');
        $story->setStatus($status);
        
        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')->find($this->getParam('boardId'));
        $story->setBoard($board);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($story);  
        $em->flush();       
    
        return $this->restResponse($story->getArray(), 201);
    }
    
    /**
     * Update an existing story
     * 
     * @param integer $storyId
     * @param Request $request     
     */
    public function putAction($storyId, Request $request)
    {       
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        $story = $repo->find($storyId);
        
        if (!$story) {
            throw $this->createNotFoundException('No story found for id '. $storyId);
        }
        
        $story->setContent($this->getParam('content'));

        $story->setSort($this->getParam('sort'));
        $story->setPoints($this->getParam('points'));

        $status = $this->getDoctrine()->getRepository('itsallagileCoreBundle:StoryStatus')
            ->find($this->getParam('status'));
        $story->setStatus($status);

        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')->find($this->getParam('boardId'));
        $story->setBoard($board);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($story);  
        $em->flush();       
    
        return $this->restResponse($story->getArray(), 201);
    }
    
    /**
     * Delete a story
     * @param integer $storyId
     * @return type     
     */
    public function deleteAction($storyId)
    { 
        
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        $story = $repo->find($storyId);
        
        if (!$story) {
            throw $this->createNotFoundException('No story found for id '. $storyId);
        }
              
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($story);
        $em->flush();
    
        return $this->restResponse(array(), 201);
    }
    
}
