<?php

namespace App\Notification;

use App\Message\UserCreatedMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class NotificationService
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[AsMessageHandler]
    public function handleNotifyUserCreatedMessage(UserCreatedMessage $message)
    {
        $this->logger->info('User created: ', [
            'email' => $message->getEmail(),
            'first_name' => $message->getFirstName(),
            'last_name' => $message->getLastName(),
        ]);
    }
}