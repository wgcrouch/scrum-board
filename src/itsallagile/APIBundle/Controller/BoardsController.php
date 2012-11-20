<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\Board;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BoardsController extends FOSRestController
{
    /**
     * Get a single Board
     */
    public function getBoardAction(Board $board)
    {
        $view = View::create();
        $view->setData($board);
        return $view;
    }

    /**
     * Get all boards
     */
    public function getBoardsAction()
    {
        $view = View::create();
        $repository = $this->get()->getRepository('itsallagileCoreBundle:Board');
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
