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
class StoriesController extends FOSRestController implements ApiController
{

    public function getStoriesAction(Board $board)
    {
        return $board->getStories();
    }

    public function getStoryAction(Board $board, $storyId)
    {
        return $this->getStory($board, $storyId);
    }

    protected function getStory(Board $board, $storyId)
    {
        $story = $board->getStory($storyId);
        if (!$story) {
            throw $this->createNotFoundException('Story ' . $storyId . ' not found');
        }
        return $story;
    }

    /**
     * Create a new story
     */
    public function postStoriesAction(Board $board, Request $request)
    {
        $view = View::create();
        $story = new Story();
        $form = $this->createForm(new StoryType(), $story);
        $form->bind($request);

        if ($form->isValid()) {
            if (!$story->getStatus()) {
                $story->setStatus(Story::STATUS_NEW);
            }
            $dm = $this->get('doctrine_mongodb')->getManager();
            $board->addStory($story);
            $dm->persist($board);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($story);
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Update a story
     */
    public function putStoryAction(Board $board, $storyId, Request $request)
    {
        $view = View::create();
        $story = $this->getStory($board, $storyId);
        $form = $this->createForm(new StoryType(true), $story);
        $form->bind($request);

        if ($form->isValid()) {

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($story);
            $dm->flush();

            $view->setStatusCode(200);
            $view->setData($story);
        } else {
            $view->setData($form);
        }
        return $view;
    }

    /**
     * Delete a Story
     * @param integer $storyId
     * @return type
     */
    public function deleteStoryAction(Board $board, $storyId)
    {
        $view = View::create();
        $story = $this->getStory($board, $storyId);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $board->removeStory($story);
        $dm->persist($board);
        $dm->flush();
        $view->setStatusCode(200);
        return $view;
    }
}
