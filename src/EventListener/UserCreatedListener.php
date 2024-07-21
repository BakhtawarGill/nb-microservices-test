<?php

namespace App\EventListener;

use App\Event\UserCreatedEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\UserCreatedMessage;


class UserCreatedListener
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function onUserCreated(UserCreatedEvent $event)
    {
        $user = $event->getUser();
        $this->bus->dispatch(
            new UserCreatedMessage(
                $user->getEmail(),
                $user->getFirstName(),
                $user->getLastName()
            )
        );
    }
}