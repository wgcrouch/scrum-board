<?php
namespace itsallagile\APIBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase AS WTC;

/**
 * Base test case for functional testing of the api
 */
class ApiTestCase extends WTC
{
    
    protected $userAuth = array(
            'PHP_AUTH_USER' => 'init@example.com',
            'PHP_AUTH_PW'   => 'password',
    );
    
    protected $adminAuth = array(
            'PHP_AUTH_USER' => 'admin@example.com',
            'PHP_AUTH_PW'   => 'password',
    );
    
    
    /**
     * Check if the response is json, and check the response code
     * 
     * @param \Symfony\Component\BrowserKit\Response $response
     * @param integer $statusCode
     */
    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}

