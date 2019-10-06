<?php

namespace Tests\AppBundle\Service;

use AppBundle\Service\TaskListener;
use PHPStan\Testing\TestCase;
use Predis\Client;

class TaskListenerTest extends TestCase
{
    /**
     * @var TaskListener
     */
    private $taskListener;

    public function setUp()
    {
        $cacheDriver = $this->createMock(Client::class);

        $this->taskListener = new TaskListener($cacheDriver);
    }

    public function testPostPersist()
    {
        $this->assertNull($this->taskListener->postPersist());
    }

    public function testPostUpdate()
    {
        $this->assertNull($this->taskListener->postUpdate());
    }

    public function testPostRemove()
    {
        $this->assertNull($this->taskListener->postRemove());
    }
}