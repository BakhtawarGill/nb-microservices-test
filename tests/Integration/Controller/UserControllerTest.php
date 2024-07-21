<?php

namespace App\Tests\Integration\Controller;

use App\Controller\UserController;
use App\Handler\CreateUserHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserControllerTest extends KernelTestCase
{
    private $entityManager;
    private $controller;
    private $request;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $validator = self::getContainer()->get('validator');
        $eventDispatcher = $kernel->getContainer()->get('event_dispatcher');
        $this->controller = new UserController(new CreateUserHandler($this->entityManager, $validator, $eventDispatcher));
        $this->request = new Request();
    }

    public function testCreateUserSuccess()
    {
        $userData = [
            'email' => 'user@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $this->request = new Request([], [], [], [], [], [], json_encode($userData));
        $this->request->headers->set('Content-Type', 'application/json');

        $serializer = self::getContainer()->get('serializer');

        $response = $this->controller->createUser($this->request, $serializer);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseContent = $response->getContent();

        $this->assertEquals('User created successfully', $responseContent);
    }
}
