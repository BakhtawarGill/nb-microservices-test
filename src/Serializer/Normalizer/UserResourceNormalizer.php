<?php

namespace App\Serializer\Normalizer;

use App\Serializer\UserResource;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserResourceNormalizer implements NormalizerInterface
{
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof UserResource;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        /* @var UserResource $object */
        $user = $object->getUser();

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            UserResource::class => true,
        ];
    }
}


