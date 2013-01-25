<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use itsallagile\CoreBundle\Document\Board;
use itsallagile\CoreBundle\Form\Type\Board\Add;

use Symfony\Component\HttpFoundation\Request;

class BoardController extends Controller
{

    public function addAction(Request $request)
    {
        $board = new Board();
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new Add($user), $board);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();
                $em->persist($board);
                $em->flush();
                return $this->redirect(
                    $this->generateUrl(
                        'itsallagileScrumboardBundle_viewboard',
                        array('slug' => $board->getSlug())
                    )
                );
            }
        }

        return $this->render('itsallagileCoreBundle:Board:add.html.twig', array('form' => $form->createView()));
    }
}
