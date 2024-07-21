<?php

namespace App\Tests\Unit\Controller;

use App\Controller\UserController;
use App\Handler\CreateUserHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserControllerTest extends TestCase
{
    public function testCreateUserSuccess()
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'email' => 'user@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]));

        $createUserHandler = $this->createMock(CreateUserHandler::class);
        $createUserHandler->expects($this->once())
            ->method('handle')
            ->withAnyParameters();

        $serializer = $this->createMock(SerializerInterface::class);

        $controller = new UserController($createUserHandler);
        $response = $controller->createUser($request, $serializer);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testCreateUserInvalidData()
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'email' => '',
            'first_name' => '',
            'last_name' => '',
        ]));

        $createUserHandler = $this->createMock(CreateUserHandler::class);
        $createUserHandler->expects($this->once())
            ->method('handle')
            ->withAnyParameters()
            ->willThrowException(new InvalidArgumentException());

        $serializer = $this->createMock(SerializerInterface::class);

        $containerMock = $this->createMock(ContainerInterface::class);

        $abstractControllerMock = $this->getMockBuilder(AbstractController::class)
            ->setMethods(['getContainer'])
            ->getMock();

        $abstractControllerMock->method('getContainer')->willReturn($containerMock);

        $controller = new UserController($createUserHandler);
        $controller->setContainer($containerMock);

        $response = $controller->createUser($request, $serializer);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

}