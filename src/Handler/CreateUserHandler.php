<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use App\Message\UserCreatedMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\UserCreatedEvent;

class CreateUserHandler
{
    private EntityManagerInterface $em;
    private ValidatorInterface $validator;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(CreateUserCommand $command): User
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $user->setFirstName($command->getFirstName());
        $user->setLastName($command->getLastName());

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorArray = [];
            foreach ($errors as $error) {
                $errorArray[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            throw new \InvalidArgumentException(json_encode($errorArray));
        }

        $this->em->persist($user);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new UserCreatedEvent($user)
        );

        return $user;
    }
}

