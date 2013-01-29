<?php

namespace itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use itsallagile\CoreBundle\Document\Board;
use itsallagile\CoreBundle\Document\Story;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BoardsController extends FOSRestController implements ApiController
{
    /**
     * Get a single Board
     */
    public function getBoardAction(Board $board)
    {
        return $board;
    }

    /**
     * Get all boards
     */
    public function getBoardsAction()
    {
        $repository = $this->get('doctrine_mongodb')->getRepository('itsallagileCoreBundle:Board');
        $data = array();
        $boards = $repository->findAll();

        foreach ($boards as $board) {
            $data[] = $board;
        }

        return $data;
    }
}
