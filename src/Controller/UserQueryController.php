<?php

namespace App\Controller;

use App\Entity\User;
use App\Serializer\UserResource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class UserQueryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/users/{id}', methods: ['GET'])]
    public function fetchUser(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userResource = new UserResource($user);
        $serializedData = $this->serializer->serialize($userResource, 'json');

        return new Response($serializedData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}

