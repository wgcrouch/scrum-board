<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Ticket,
    Symfony\Component\HttpFoundation\Request;

class TicketsController extends RestController
{
    
    public function getAction(Request $request)
    { 
        $data = array();
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Ticket');
        $tickets = $repository->findAll();
        foreach($tickets as $ticket) {
            $data[$ticket->getTicketId()] = $ticket->getArray();
        }
        return $this->restResponse($data);
    }
    
}
