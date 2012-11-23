<?php

namespace itsallagile\ScrumboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use itsallagile\CoreBundle\Document\Board;
use itsallagile\CoreBundle\Document\Ticket;
use itsallagile\CoreBundle\Document\Story;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ScrumboardController extends Controller
{
    /**
     * The main scrum board page
     * 
     * @param Board $board
     * @ParamConverter("board", class="itsallagile\CoreBundle\Document\Board")
     */
    public function indexAction($board)
    {
        $user = $this->get('security.context')->getToken()->getUser();

//        if (!$user->hasTeam($board->getTeam())) {
//            throw new AccessDeniedHttpException('You do not have access to this board');
//        }
        
        $serializer = $this->get('serializer');
             
        $ticketStatuses = array();
        foreach (Ticket::getStatuses() as $id => $status) {
            $ticketStatuses[] = array('id' => $id, 'status'=> $status);
        }
        
        $storyStatuses = array();
        foreach (Story::getStatuses() as $id => $status) {
            $storyStatuses[] = array('id' => $id, 'status'=> $status);
        }
        $viewData = array(
            'board' => $board,
            'boardJson' => $serializer->serialize($board, 'json'),
            'ticketStatuses' => $ticketStatuses,
            'storyStatuses' => $storyStatuses
        );

        return $this->render('itsallagileScrumboardBundle:Board:index.html.twig', $viewData);
    }
}
