<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\Ticket;
use itsallagile\CoreBundle\Document\Board;
use itsallagile\CoreBundle\Document\Story;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\TicketType;

/**
 * Rest controller for tickets
 */
class TicketsController extends FOSRestController
{
    /**
     * Get a story from the board and storyId and check that it was successful
     * @param Board $board
     * @param string $storyId
     */
    protected function getStory(Board $board, $storyId) 
    {
        $story = $board->getStory($storyId);
        if (!$story) {
            throw $this->createNotFoundException('Could not find story' . $storyId);
        }
        return $story;
    }
    
    /**
     * Get a single ticket for a story in a board
     * 
     * @param Board $board
     * @param string $storyId
     * @param string $ticketId
     */
    public function getTicketAction(Board $board, $storyId, $ticketId)
    {
        $story = $this->getStory($board, $storyId);
        
        $ticket = $story->getTicket($ticketId);
        if (!$ticket) {
            throw $this->createNotFoundException('Could not find ticket ' . $ticketId);
        }
        return $ticket;
    }

    /**
     * Get all tickets for a story in a board
     * 
     * @param Board $board
     * @param string $storyId
     */
    public function getTicketsAction(Board $board, $storyId)
    {
        $story = $this->getStory($board, $storyId);

        return $story->getTickets();
    }

//    /**
//     * Create a new ticket
//     */
//    public function postTicketsAction(Request $request)
//    {
//        $view = View::create();
//        $ticket = new Ticket();
//        $form = $this->createForm(new TicketType(), $ticket);
//        $form->bind($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($ticket);
//            $em->flush();
//            $view->setStatusCode(201);
//            $view->setData($ticket->getArray());
//        } else {
//            $view->setData($form);
//        }
//        return $view;
//    }
//
//    /**
//     * Update a ticket
//     */
//    public function putTicketAction($ticketId, Request $request)
//    {
//        $view = View::create();
//        $ticket = $this->getTicket($ticketId);
//        $form = $this->createForm(new TicketType(), $ticket);
//        $form->bind($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($ticket);
//            $em->flush();
//
//            $view->setStatusCode(200);
//            $view->setData($ticket->getArray());
//        } else {
//            $view->setData($form);
//        }
//        return $view;
//    }
//
//    /**
//     * Delete a ticket
//     * @param integer $ticketId
//     * @return type
//     */
//    public function deleteTicketAction($ticketId)
//    {
//        $view = View::create();
//        $ticket = $this->getTicket($ticketId);
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->remove($ticket);
//        $em->flush();
//        $view->setStatusCode(200);
//        return $view;
//    }
//
//    protected function getRepository()
//    {
//        return $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
//    }
//
//    protected function getTicket($ticketId)
//    {
//        $ticket = $this->getRepository()->find($ticketId);
//        if (!$ticket) {
//            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
//        }
//        return $ticket;
//    }
}
