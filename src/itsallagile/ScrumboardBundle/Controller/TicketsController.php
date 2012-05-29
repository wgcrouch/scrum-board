<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Ticket,
    Symfony\Component\HttpFoundation\Request;

class TicketsController extends RestController
{
    
    public function getAction($ticketId = null)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        if (!empty($ticketId))  {       
            $ticket = $repository->find($ticketId);

            if (!$ticket) {
                throw $this->createNotFoundException('No product found for id '.$id);
            }
            $data = $ticket->getArray();
        } else {
            $data = array();
            $tickets = $repository->findAll();
            
            foreach($tickets as $ticket) {
                $data[$ticket->getTicketId()] = $ticket->getArray();
            }

        }
     
        return $this->restResponse($data, 201);
        
    }
    
    public function postAction(Request $request)
    {        
        $ticket = new Ticket();
        $ticket->setContent($request->get('content'));

        $ticket->setX($request->get('x'));
        $ticket->setY($request->get('y'));
        $ticket->setParent($request->get('parent'));        
        $ticket->setType($request->get('type'));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticket);  
        $em->flush();       
    
        return $this->restResponse($ticket->getArray(), 201);
    }
    
    public function putAction($ticketId, Request $request)
    {       
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        
        $ticket = $repo->find($ticketId);
        
        if (!$ticket) {
            throw $this->createNotFoundException('No ticket found for id '. $ticketId);
        }
        
        $ticket->setContent($request->get('content'));

        $ticket->setX($request->get('x'));
        $ticket->setY($request->get('y'));
        $ticket->setParent($request->get('parent'));        
        $ticket->setType($request->get('type'));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticket);  
        $em->flush();       
    
        return $this->restResponse($ticket->getArray(), 201);
    }
    
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
