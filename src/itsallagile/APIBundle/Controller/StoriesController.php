<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\Story;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\StoryType;
use itsallagile\CoreBundle\Document\Board;

/**
 * Rest controller for stories
 */
class StoriesController extends FOSRestController
{
    
    public function getStoriesAction(Board $board) 
    {
        return $board->getStories();
    }
    
    public function getStoryAction(Board $board, $storyId) 
    {
        $story = $board->getStory($storyId);
        if (!$story) {
            throw $this->createNotFoundException('Story ' . $storyId . ' not found');
        }
        return $story;
    }

//    /**
//     * Create a new story
//     */
//    public function postStoriesAction(Request $request)
//    {
//        $view = View::create();
//        $story = new Story();
//        $form = $this->createForm(new StoryType(), $story);
//        $form->bind($request);  
//        
//        if ($form->isValid()) {            
//            
//            if (!$story->getStatus()) {
//                $status = $this->getDoctrine()->getRepository('itsallagileCoreBundle:StoryStatus')
//                    ->findOneByName('New');
//                $story->setStatus($status);
//            }
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($story);
//            $em->flush();
//            $view->setStatusCode(201);
//            $view->setData($story->getArray());
//        } else {
//            $view->setData($form);
//        }
//        return $view;
//    }
//
//    /**
//     * Update a story
//     */
//    public function putStoryAction($storyId, Request $request)
//    {
//        $view = View::create();
//        $story = $this->getStory($storyId);
//        $form = $this->createForm(new StoryType(), $story);
//        $form->bind($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getEntityManager();
//            $em->persist($story);
//            $em->flush();
//
//            $view->setStatusCode(200);
//            $view->setData($story->getArray());
//        } else {
//            $view->setData($form);
//        }
//        return $view;
//    }
//
//    /**
//     * Delete a Story
//     * @param integer $storyId
//     * @return type
//     */
//    public function deleteStoryAction($storyId)
//    {
//        $view = View::create();
//        $story = $this->getStory($storyId);
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->remove($story);
//        $em->flush();
//        $view->setStatusCode(200);
//        return $view;
//    }
//
//    protected function getRepository()
//    {
//        return $this->getDoctrine()->getRepository('itsallagileCoreBundle:Story');
//    }
//
//    protected function getStory($storyId)
//    {
//        $story = $this->getRepository()->find($storyId);
//        if (!$story) {
//            throw $this->createNotFoundException('No story found for id ' . $storyId);
//        }
//        return $story;
//    }
}
