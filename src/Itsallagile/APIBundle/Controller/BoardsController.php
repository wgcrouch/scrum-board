<?php

namespace Itsallagile\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Itsallagile\CoreBundle\Document\Board;
use Itsallagile\CoreBundle\Document\Story;
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
}
