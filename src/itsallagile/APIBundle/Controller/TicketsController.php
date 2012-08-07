<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController,
    itsallagile\CoreBundle\Entity\Ticket,
    Symfony\Component\HttpFoundation\Request,
    FOS\RestBundle\View\View,
    itsallagile\APIBundle\Form\TicketType;

/**
 * Rest controller for tickets 
 */
class TicketsController extends FOSRestController
{
    
    /**
     * Get a single ticket
     * 
     * @param integer $ticketId     
     */
    public function getTicketAction($ticketId)
    { 
        $view = View::create();
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        $ticket = $repository->find($ticketId);

        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
        
     
        $view->setData($ticket);
        return $view;
        
    }
    
    /**
     * Get all tickets     
     */
    public function getTicketsAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        $data = array();
        $tickets = $repository->findAll();

        foreach($tickets as $ticket) {
            $data[$ticket->getTicketId()] = $ticket->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
    /**
     * 
     */
    public function postTicketsAction(Request $request)
    {
        $view = View::create();
        $ticket = new Ticket();
        $form = $this->createForm(new TicketType(), $ticket);

        $form->bind($request); 
        print_r($request);
        die();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($ticket);
            $em->flush();            
            $view->setStatusCode(201); 
            $view->setData($ticket);
        } else {
            $view->setData($form);
        }
        return $view;
    }
    
//    /**
//     * Create a new ticket
//     * 
//     * @param Request $request     
//     */
//    public function postAction(Request $request)
//    {        
//        $ticket = new Ticket();
//
//        $ticket->setContent($this->getParam('content'));
//        $ticket->setParent($this->getParam('parent'));        
//        $ticket->setType($this->getParam('type'));
//
//        $story = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story')
//            ->find($this->getParam('story'));
//        $ticket->setStory($story);
//        
//        $status = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Status')
//            ->find($this->getParam('status'));
//        $ticket->setStatus($status);
//        
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($ticket);  
//        $em->flush();       
//    
//        return $this->restResponse($ticket->getArray(), 201);
//    }
//    
//    /**
//     * Update an existing ticket
//     * 
//     * @param integer $ticketId
//     * @param Request $request     
//     */
//    public function putAction($ticketId, Request $request)
//    {       
//        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
//        
//        $ticket = $repo->find($ticketId);
//        
//        if (!$ticket) {
//            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
//        }
//        
//        $ticket->setContent($this->getParam('content'));
//        $ticket->setParent($this->getParam('parent'));        
//        $ticket->setType($this->getParam('type'));
//
//        $story = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story')
//            ->find($this->getParam('story'));
//        $ticket->setStory($story);
//        
//        $status = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Status')
//            ->find($this->getParam('status'));
//        $ticket->setStatus($status);
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($ticket);  
//        $em->flush();       
//    
//        return $this->restResponse($ticket->getArray(), 201);
//    }
//    
//    /**
//     * Delete a ticket
//     * @param integer $ticketId
//     * @return type     
//     */
//    public function deleteAction($ticketId)
//    { 
//        
//        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
//        
//        $ticket = $repo->find($ticketId);
//        
//        if (!$ticket) {
//            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
//        }
//              
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->remove($ticket);
//        $em->flush();
//    
//        return $this->restResponse(array(), 201);
//    }
    
}
