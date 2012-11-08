<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Entity\ChatMessage;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\ChatMessageType;

/**
 * Rest controller for stories
 */
class MessagesController extends FOSRestController
{
    /**
     * Get a single message
     *
     * @param integer $chatMessageId
     */
    public function getMessageAction($chatMessageId)
    {
        $view = View::create();
        $chatMessage = $this->getChatMessage($chatMessageId);
        $view->setData($chatMessage->getArray());
        return $view;

    }

    /**
     * Create a new message
     */
    public function postMessagesAction(Request $request)
    {
        $view = View::create();
        $chatMessage = new ChatMessage();
        $form = $this->createForm(new ChatMessageType(), $chatMessage);
        $form->bind($request);
        $user = $this->get('security.context')->getToken()->getUser();
        $chatMessage->setUser($user);
        if ($form->isValid()) {
            $chatMessage->setDatetime(new \DateTime());
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($chatMessage);
            $em->flush();
            $view->setStatusCode(201);
            $view->setData($chatMessage->getArray());
        } else {
            $view->setData($form);
        }
        return $view;
    }

    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('itsallagileCoreBundle:ChatMessage');
    }

    protected function getChatMessage($chatMessageId)
    {
        $chatMessageId = $this->getRepository()->find($chatMessageId);
        if (!$chatMessageId) {
            throw $this->createNotFoundException('No message found for id ' . $chatMessageId);
        }
        return $chatMessageId;
    }
}
