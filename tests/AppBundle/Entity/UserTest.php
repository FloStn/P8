<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;

class UserTest extends TestEntity
{
    public function getObject()
    {
        return new User();
    }

    public function provideScalarProperties(): \Generator
    {
        yield ["username", "username"];
        yield ["roles", ["ROLE_USER"]];
        yield ["password", "password"];
        yield ["email", "email"];
    }

    public function testSaltAndCredentials()
    {
        $this->assertNull($this->object->getSalt());
        $this->assertNull($this->object->eraseCredentials());
    }
}