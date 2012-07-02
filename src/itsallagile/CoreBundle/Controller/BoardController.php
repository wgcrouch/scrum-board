<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    itsallagile\CoreBundle\Entity\Team,
    itsallagile\CoreBundle\Entity\Board,
    itsallagile\CoreBundle\Form\Type\Board\Add,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class BoardController extends Controller
{
    
    public function addAction(Request $request)
    {
        $board = new Board();
        
        $form = $this->createForm(new Add(), $board);
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($board);
                $em->flush();
                return $this->redirect($this->generateUrl('itsallagileScrumboardBundle_viewboard', array(
                    'slug' => $board->getSlug()
                )));
            }
        }        
        
        return $this->render('itsallagileCoreBundle:Board:add.html.twig', array('form' => $form->createView()));
    }
}
