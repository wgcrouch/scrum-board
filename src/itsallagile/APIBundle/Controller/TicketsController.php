<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\TicketType;

/**
 * Rest controller for tickets
 */
class TicketsController extends FOSRestController
{

    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
    }

    protected function getTicket($ticketId)
    {
        $ticket = $this->getRepository()->find($ticketId);
        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
        return $ticket;
    }

    /**
     * Get a single ticket
     *
     * @param integer $ticketId
     */
    public function getTicketAction($ticketId)
    {
        $view = View::create();
        $ticket = $this->getTicket($ticketId);
        $view->setData($ticket->getArray());
        return $view;

    }

    /**
     * Get all tickets
     */
    public function getTicketsAction()
    {
        $view = View::create();

        $data = array();
        $tickets = $this->getRepository->findAll();

        foreach ($tickets as $ticket) {
            $data[$ticket->getTicketId()] = $ticket->getArray();
        }

        $view->setData($data);
        return $view;
    }

    /**
     * Post tickets
     */
    public function postTicketsAction(Request $request)
    {

        $view = View::create();
        $ticket = new Ticket();
        $form = $this->createForm(new TicketType(), $ticket);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ticket);
            $em->flush();
            $view->setStatusCode(201);
            $view->setData($ticket->getArray());
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Put ticket
     */
    public function putTicketAction($ticketId, Request $request)
    {
        $view = View::create();
        $ticket = $this->getTicket($ticketId);
        $form = $this->createForm(new TicketType(), $ticket);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ticket);
            $em->flush();
            $view->setStatusCode(200);
            $view->setData($ticket->getArray());
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Delete a ticket
     * @param integer $ticketId
     * @return type
     */
    public function deleteTicketAction($ticketId)
    {
        $view = View::create();
        $ticket = $this->getTicket($ticketId);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($ticket);
        $em->flush();
        $view->setStatusCode(200);
        return $view;
    }
}
