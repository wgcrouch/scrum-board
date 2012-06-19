<?php
namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Core\SecurityContext,
    Symfony\Component\HttpFoundation\Response,
    itsallagile\CoreBundle\Entity\User,
    itsallagile\CoreBundle\Form\Type\User\Registration;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('itsallagileCoreBundle:Security:login.html.twig', array(
            'lastEmail' => $request->get('email'),
            'error' => $error,
        ));
    }

    public function registerAction()
    {
        $em = $this->get('doctrine')->getEntityManager();
        $request = $this->get('request');
        
        $user = new User();
        $form = $this->get('form.factory')->create(new Registration(), $user);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $factory = $this->get('security.encoder_factory');

                $encoder = $factory->getEncoder($user);
                
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                
                $user->setPassword($password);
                
                $em->persist($user);
                $em->flush();
                
//                creates a token and assigns it, effectively logging the user in with the credentials they just registered
//                $token = new UsernamePasswordToken($user, null, 'main');
//                $this->get('security.context')->setToken($token);

                return $this->redirect($this->generateUrl('login'));
            }
        }

        return $this->render('itsallagileCoreBundle:Security:register.html.twig', array('form' => $form->createView()));
    }
}