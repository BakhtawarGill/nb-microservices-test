<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testCreateUser()
    {
        $client = self::createClient();

        // Make a POST request to the /users endpoint
        $client->request(
            'POST',
            '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'user@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
            ])
        );

        $response = $client->getResponse();

        // Assert the response status code and content
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('User created successfully', $response->getContent());
    }
}
