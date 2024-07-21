<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Command\CreateUserCommand;
use App\Handler\CreateUserHandler;
use App\Entity\User;
use App\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Serializer\UserResource;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private CreateUserHandler $createUserHandler;

    public function __construct(CreateUserHandler $createUserHandler)
    {
        $this->createUserHandler = $createUserHandler;
    }

    #[Route('/users', name: 'createUser')]
    public function createUser(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateUserCommand(
            $data['email'],
            $data['first_name'],
            $data['last_name']
        );

        try {
            $this->createUserHandler->handle($command);
            return new Response('User created successfully', Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['errors' => json_decode($e->getMessage())], Response::HTTP_BAD_REQUEST);
        }

     


    }
}
