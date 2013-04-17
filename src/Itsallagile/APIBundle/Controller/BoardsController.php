<?php

namespace Itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Itsallagile\CoreBundle\Document\Board;
use Symfony\Component\HttpFoundation\Request;
use Itsallagile\APIBundle\Form\BoardType;
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
        $user = $this->get('security.context')->getToken()->getUser();
        $dm = $this->get('doctrine_mongodb');
        $data = array();
        $teams = $dm->getRepository('ItsallagileCoreBundle:Team')
            ->findAllByUser($user);
        $boards = $dm->getRepository('ItsallagileCoreBundle:Board')
            ->findAllByTeams($teams);

        foreach ($boards as $board) {
            $data[] = $board;
        }

        return $data;
    }

    /**
     * Add a new Board
     * @param  Request $request
     */
    public function postBoardsAction(Request $request)
    {
        $view = View::create();
        $board = new Board();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new BoardType($user), $board);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($board);
            $dm->flush();
            $view->setStatusCode(201);
            $view->setData($board);
        } else {
            $view->setData($form);
        }
        return $view;
    }
}
