<?php

namespace App\MessageHandler;

use App\Message\UserCreatedMessage;
use App\Message\NotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class UserCreatedMessageHandler
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(UserCreatedMessage $message)
    {
        $notifyMessage = new NotificationMessage(
            $message->getEmail(),
            $message->getFirstName(),
            $message->getLastName()
        );

        $this->messageBus->dispatch($notifyMessage);
    }
}
