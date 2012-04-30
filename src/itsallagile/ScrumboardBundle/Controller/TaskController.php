<?php

namespace itsallagile\ScrumboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Serializer\Serializer,
    Symfony\Component\Serializer\Encoder;

class TaskController extends Controller
{
    
    public function indexAction()
    { 
        $data = array('status'=> 'success');

        $serializer = new Serializer(array(), array(
            'json' => new Encoder\JsonEncoder(),
            'xml' => new Encoder\XmlEncoder()
        ));

        return new Response($serializer->encode($data, $this->getRequest()->get('_format')));
    }
}
