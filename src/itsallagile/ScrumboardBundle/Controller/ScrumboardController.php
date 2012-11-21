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
             
        $viewData = array(
            'board' => $board,
            'boardJson' => $serializer->serialize($board, 'json'),
            'ticketStatuses' => Ticket::getStatuses(),
            'storyStatuses' => Story::getStatuses()
        );

        return $this->render('itsallagileScrumboardBundle:Board:index.html.twig', $viewData);
    }
}
