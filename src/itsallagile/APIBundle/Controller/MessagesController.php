<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\ChatMessage;
use itsallagile\CoreBundle\Document\Board;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\ChatMessageType;

/**
 * Rest controller for stories
 */
class MessagesController extends FOSRestController
{
    /**
     * Get a single message from this boards messages
     * 
     * @param Board $board
     * @param string $chatMessageId
     */
    public function getMessageAction(Board $board, $chatMessageId)
    {
        $message = $board->getChatMessage($chatMessageId);
        if (!$message) {
           throw $this->createNotFoundException('Could not find message ' . $chatMessageId);
        }
        return $message;
    }
    
    /**
     * Get all messages for a board
     * 
     * @param Board $board
     * @param string $chatMessageId
     */
    public function getMessagesAction(Board $board)
    {
        return $board->getChatMessages();
    }

//    /**
//     * Create a new message
//     */
//    public function postMessagesAction(Request $request)
//    {
//        $view = View::create();
//        $chatMessage = new ChatMessage();
//        $form = $this->createForm(new ChatMessageType(), $chatMessage);
//        $form->bind($request);
//        $user = $this->get('security.context')->getToken()->getUser();
//        $chatMessage->setUser($user);
//        if ($form->isValid()) {
//            $chatMessage->setDatetime(new \DateTime());
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($chatMessage);
//            $em->flush();
//            $view->setStatusCode(201);
//            $view->setData($chatMessage->getArray());
//        } else {
//            $view->setData($form);
//        }
//        return $view;
//    }
//
//    protected function getRepository()
//    {
//        return $this->getDoctrine()->getRepository('itsallagileCoreBundle:ChatMessage');
//    }
//
//    protected function getChatMessage($chatMessageId)
//    {
//        $chatMessageId = $this->getRepository()->find($chatMessageId);
//        if (!$chatMessageId) {
//            throw $this->createNotFoundException('No message found for id ' . $chatMessageId);
//        }
//        return $chatMessageId;
//    }
}
