<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\StoryStatus,
    Symfony\Component\HttpFoundation\Request;

/**
 * Rest controller for statuses
 */
class StoryStatusesController extends RestController
{
    
    /**
     * Get a single status
     * 
     * @param integer $statusId     
     */
    public function getAction($statusId)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:StoryStatus');
        
        $status = $repository->find($statusId);

        if (!$status) {
            throw $this->createNotFoundException('No status found for id '. $statusId);
        }
        $data = $status->getArray();
     
        return $this->restResponse($data, 201);
        
    }
    
    /**
     * Get all statuses
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:StoryStatus');
        $data = array();
        $statuses = $repository->findAll();

        foreach ($statuses as $status) {
            $data[$status->getStatusId()] = $status->getArray();
        }
     
        return $this->restResponse($data, 201);
    }
    
}
