<?php

namespace itsallagile\ApiBundle\Tests\Controller;

use itsallagile\APIBundle\Tests\ApiTestCase;

class BoardsControllerTest extends ApiTestCase
{
    public function testGetAll()
    {
        $client = static::createClient();

        $client->request('GET', '/api/boards', array(), array(), $this->userAuth);
        
        $response = $client->getResponse();
        $this->assertJsonResponse($response);
        $result = json_decode($response->getContent(), true);
        
        $this->assertEquals(2, count($result));
        $this->assertEquals('Example Board', $result[1]['name']);
        
        return $result[1]['id'];
    }
    
    /**
     * @depends testGetAll
     */
    public function testGetOneWithValidId($id)
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/api/boards/' . $id,
            array(),
            array(), 
            $this->userAuth
        );
        
        $response = $client->getResponse();
        $this->assertJsonResponse($response);
        $result = json_decode($response->getContent(), true);

        $this->assertEquals('Example Board', $result['name']);
        
        $params = array('id', 'name', 'slug', 'team', 'stories');
        foreach ($params as $param) {
            $this->assertTrue(array_key_exists($param, $result));
        }
        
    }
    
    public function testGetOneWithInValidId()
    {
        $client = static::createClient();

        $client->request('GET', '/api/boards/fooo', array(), array(), $this->userAuth);
        
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 404);

    }        
}
