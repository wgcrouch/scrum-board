<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\Ticket;
use itsallagile\CoreBundle\Document\Board;
use itsallagile\CoreBundle\Document\Story;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\TicketType;
use itsallagile\APIBundle\Events;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Rest controller for tickets
 */
class TicketsController extends FOSRestController implements ApiController
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

    protected function getTicket(Story $story, $ticketId)
    {
        $ticket = $story->getTicket($ticketId);
        if (!$ticket) {
            throw $this->createNotFoundException('Could not find ticket' . $ticketId);
        }
        return $ticket;
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

        $ticket = $this->getTicket($story, $ticketId);
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

    /**
     * Create a new ticket
     */
    public function postTicketsAction(Board $board, $storyId, Request $request)
    {
        $story = $this->getStory($board, $storyId);
        $view = View::create();
        $ticket = new Ticket();
        $form = $this->createForm(new TicketType(), $ticket);
        $form->bind($request);

        if ($form->isValid()) {
            if (!$ticket->getStatus()) {
                $ticket->setStatus(Ticket::STATUS_NEW);
            }
            $dm = $this->get('doctrine_mongodb')->getManager();
            $story->addTicket($ticket);
            $dm->persist($story);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($ticket);
            $this->get('event_dispatcher')->dispatch(Events::TICKET_CREATE, new GenericEvent($ticket));
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Update a ticket
     */
    public function putTicketAction(Board $board, $storyId, $ticketId, Request $request)
    {
        $view = View::create();
        $story = $this->getStory($board, $storyId);
        $ticket = $this->getTicket($story, $ticketId);
        $form = $this->createForm(new TicketType(true), $ticket);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($ticket);
            $dm->flush();

            $view->setStatusCode(200);
            $view->setData($ticket);
            $this->get('event_dispatcher')->dispatch(Events::TICKET_UPDATE, new GenericEvent($ticket));
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Delete a Ticket
     */
    public function deleteTicketAction(Board $board, $storyId, $ticketId)
    {
        $view = View::create();
        $story = $this->getStory($board, $storyId);
        $ticket = $this->getTicket($story, $ticketId);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $this->get('event_dispatcher')->dispatch(Events::TICKET_DELETE, new GenericEvent($ticket));
        $story->removeTicket($ticket);
        $dm->persist($story);
        $dm->flush();
        $view->setStatusCode(200);
        return $view;
    }
}
