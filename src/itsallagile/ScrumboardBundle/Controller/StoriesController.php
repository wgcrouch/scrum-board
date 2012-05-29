<?php

namespace itsallagile\ScrumboardBundle\Controller;

use itsallagile\CoreBundle\Controller\RestController,
    itsallagile\CoreBundle\Entity\Story,
    Symfony\Component\HttpFoundation\Request;

class StoriesController extends RestController
{
    
    public function getAction($storyId = null)
    { 
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        if (!empty($storyId))  {       
            $story = $repository->find($storyId);

            if (!$story) {
                throw $this->createNotFoundException('No story found for id ' . $storyId);
            }
            $data = $story->getArray();
        } else {
            $data = array();
            $stories = $repository->findAll();
            
            foreach($stories as $story) {
                $data[$story->getstoryId()] = $story->getArray();
            }

        }
     
        return $this->restResponse($data, 201);
        
    }
    
    public function postAction(Request $request)
    {        
        $story = new Story();
        $story->setContent($request->get('content'));

        $story->setX($request->get('x'));
        $story->setY($request->get('y'));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($story);  
        $em->flush();       
    
        return $this->restResponse($story->getArray(), 201);
    }
    
    public function putAction($storyId, Request $request)
    {       
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        $story = $repo->find($storyId);
        
        if (!$story) {
            throw $this->createNotFoundException('No story found for id '. $storyId);
        }
        
        $story->setContent($request->get('content'));

        $story->setX($request->get('x'));
        $story->setY($request->get('y'));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($story);  
        $em->flush();       
    
        return $this->restResponse($story->getArray(), 201);
    }
    
    public function deleteAction($storyId)
    { 
        
        $repo = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
        
        $story = $repo->find($storyId);
        
        if (!$story) {
            throw $this->createNotFoundException('No story found for id '. $storyId);
        }
              
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($story);
        $em->flush();
    
        return $this->restResponse(array(), 201);
    }
    
}
