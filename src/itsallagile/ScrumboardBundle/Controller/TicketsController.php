<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Ticket,
    Symfony\Component\HttpFoundation\Request;

/**
 * Rest controller for tickets 
 */
class TicketsController extends RestController
{
    
    /**
     * Get a single ticket
     * 
     * @param integer $ticketId     
     */
    public function getAction($ticketId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        $ticket = $repository->find($ticketId);

        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
        $data = $ticket->getArray();
     
        return $this->restResponse($data, 201);
        
    }
    
    /**
     * Get all tickets     
     */
    public function getAllAction()
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
     * Create a new ticket
     * 
     * @param Request $request     
     */
    public function postAction(Request $request)
    {        
        $ticket = new Ticket();
        $ticket->setContent($request->get('content'));

        $ticket->setX($request->get('x'));
        $ticket->setY($request->get('y'));
        $ticket->setParent($request->get('parent'));        
        $ticket->setType($request->get('type'));
        
        $story = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story')->find($request->get('story'));
        $ticket->setStory($story);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticket);  
        $em->flush();       
    
        return $this->restResponse($ticket->getArray(), 201);
    }
    
    /**
     * Update an existing ticket
     * 
     * @param integer $ticketId
     * @param Request $request     
     */
    public function putAction($ticketId, Request $request)
    {       
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        $ticket = $repo->find($ticketId);
        
        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
        
        $data = $this->getPutData();
        $ticket->setContent($data['content']);

        $ticket->setX($data['x']);
        $ticket->setY($data['y']);
        $ticket->setParent($data['parent']);        
        $ticket->setType($data['type']);

        $story = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story')->find($data['story']);
    
        $ticket->setStory($story);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticket);  
        $em->flush();       
    
        return $this->restResponse($ticket->getArray(), 201);
    }
    
    /**
     * Delete a ticket
     * @param integer $ticketId
     * @return type     
     */
    public function deleteAction($ticketId)
    { 
        
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        $ticket = $repo->find($ticketId);
        
        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
              
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($ticket);
        $em->flush();
    
        return $this->restResponse(array(), 201);
    }
    
}
