<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public function testCanSetAndGetData(): Void
    {
        $user = new User();
        $user->setEmail('your-email@gmail.com');
        $user->setFirstName('First');
        $user->setLastName('Last');

        self::assertSame('your-email@gmail.com', $user->getEmail());
        self::assertSame('First', $user->getFirstName());
        self::assertSame('Last', $user->getLastName());

    }
    
}