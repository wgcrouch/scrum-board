<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\ChatMessage,
    Symfony\Component\HttpFoundation\Request;

class ChatMessagesController extends RestController
{
    
    /**
     * Get a single chat message
     * 
     * @param integer $chatMessageId     
     */
    public function getAction($chatMessageId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:ChatMessage');
        
        $story = $repository->find($chatMessageId);

        if (!$story) {
            throw $this->createNotFoundException('No chat message found for id '. $chatMessageId);
        }
        $data = $story->getArray();
     
        return $this->restResponse($data, 201);
        
    }
    
    /**
     * Get all messages for a board
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
        $messages = $board->getChatMessages();

        foreach($messages as $message) {
            $data[$message->getChatMessageId()] = $message->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * Create a new chatMessage
     * 
     * @param Request $request     
     */
    public function postAction(Request $request)
    {        
        $chatMessage = new ChatMessage();
        $chatMessage->setContent($this->getParam('content'));
        
        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')->find($this->getParam('boardId'));
        $chatMessage->setBoard($board);
        
        $chatMessage->setDatetime(new \DateTime());
        
        $user = $this->get('security.context')->getToken()->getUser();
        $chatMessage->setUser($user);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($chatMessage);  
        $em->flush();       
    
        return $this->restResponse($chatMessage->getArray(), 201);
    }
    
    
}
