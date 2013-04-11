<?php

namespace Itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Itsallagile\CoreBundle\Document\Board;
use Itsallagile\CoreBundle\Form\Type\Board\Add;

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
                        'ItsallagileScrumboardBundle_viewboard',
                        array('slug' => $board->getSlug())
                    )
                );
            }
        }

        return $this->render('ItsallagileCoreBundle:Board:add.html.twig', array('form' => $form->createView()));
    }
}
