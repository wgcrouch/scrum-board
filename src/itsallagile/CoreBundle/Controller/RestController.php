<?php

namespace itsallagile\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Serializer\Serializer,
    Symfony\Component\Serializer\Encoder;

/**
 * Very simple rest controller base class provifing methods to help with rest apis 
 */
class RestController extends Controller
{
    /**
     * Create a response with the correct data format and response code
     * @param array $data
     * @param integer $code
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    protected function restResponse($data, $code = 200)
    {
        $serializer = new Serializer(array(), array(
            'json' => new Encoder\JsonEncoder(),
            'xml' => new Encoder\XmlEncoder()
        ));
        return new Response($serializer->encode($data, $this->getRequest()->get('_format')), $code);
    }
    
    /**
     * Get the put data and decode according to the request format
     * @return array
     */
    protected function getPutData()
    {
        $serializer = new Serializer(array(), array(
            'json' => new Encoder\JsonEncoder(),
            'xml' => new Encoder\XmlEncoder()
        ));
        
        $data = $this->getRequest()->getContent();
        
        $values = $serializer->decode($data, $this->getRequest()->get('_format'));
        return $values;
    }
    
}
