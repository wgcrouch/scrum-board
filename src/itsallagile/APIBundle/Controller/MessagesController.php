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
class MessagesController extends FOSRestController implements ApiController
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

    /**
     * Create a new message
     */
    public function postMessagesAction(Board $board, Request $request)
    {
        $view = View::create();
        $message = new ChatMessage();
        $form = $this->createForm(new ChatMessageType(), $message);
        $form->bind($request);
        $user = $this->get('security.context')->getToken()->getUser();
        $message->setUser($user->getEmail());
        if ($form->isValid()) {
            $message->setDatetime(new \DateTime());
            $dm = $this->get('doctrine_mongodb')->getManager();
            $board->addChatMessage($message);
            $dm->persist($board);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($message);
        } else {
            $view->setData($form);
        }
        return $view;
    }
}
