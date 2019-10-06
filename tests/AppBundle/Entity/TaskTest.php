<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;

class TaskTest extends TestEntity
{
    public function getObject()
    {
        return new Task();
    }

    public function provideScalarProperties(): \Generator
    {
        yield ["done", true];
        yield ["createdAt", new \DateTime()];
        yield ["author", new User()];
        yield ["content", "content"];
        yield ["title", "title"];
    }
}