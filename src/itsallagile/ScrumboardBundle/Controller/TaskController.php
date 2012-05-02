<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Ticket;

class TaskController extends RestController
{
    
    public function getAction()
    { 
        $data = array('status'=> 'get');

        return $this->restResponse($data);
    }
    
    public function postAction()
    {
        $ticket = new Ticket();
        $ticket->setColour('colour');
        $ticket->setContent('Content Goes here');
        $ticket->setCssHash('aabbcc');
        $ticket->setX(100);
        $ticket->setY(200);
        $ticket->setParent('3');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($ticket);
        $em->flush();       

        $data = (array)$ticket;
        return $this->restResponse($data, 201);
    }
}
