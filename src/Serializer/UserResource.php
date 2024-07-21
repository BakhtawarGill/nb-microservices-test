<?
// src/Serializer/UserResource.php

namespace App\Serializer;

use App\Entity\User;

class UserResource
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
