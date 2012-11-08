<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Entity\Board;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

class BoardsController extends FOSRestController
{
    /**
     * Get a single Board
     *
     * @param integer $boardId
     */
    public function getBoardAction($boardId)
    {
        $view = View::create();
        $board = $this->getboard($boardId);
        $view->setData($board->getArray());
        return $view;
    }

    /**
     * Get all boards
     */
    public function getBoardsAction()
    {
        $view = View::create();
        $repository = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board');
        $data = array();
        $boards = $repository->findAll();

        foreach ($boards as $board) {
            $data[$board->getBoardId()] = $board->getArray();
        }

        $view->setData($data);
        return $view;
    }

    protected function getBoard($boardId)
    {
        $board = $this->getDoctrine()->getRepository('itsallagileCoreBundle:Board')
            ->find($boardId);
        if (!$board) {
            throw $this->createNotFoundException('No board found for id '. $boardId);
        }
        return $board;
    }
}
