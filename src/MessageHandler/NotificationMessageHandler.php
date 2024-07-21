<?php

namespace App\MessageHandler;

use App\Message\NotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;

#[AsMessageHandler]
class NotificationMessageHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(NotificationMessage $message)
    {
        $this->logger->info('User created: ', [
            'email' => $message->getEmail(),
            'first_name' => $message->getFirstName(),
            'last_name' => $message->getLastName(),
        ]);

        // Here, you can perform additional notification logic
        // For example, sending an email, etc.
    }
}
