<?php

namespace AppBundle\Service;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Task;

class TaskListener
{
    private $cacheDriver;

    public function __construct($cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
    }

    public function postPersist(Task $task, LifecycleEventArgs $args)
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }

    public function postUpdate(Task $task, LifecycleEventArgs $args)
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }

    public function postRemove(Task $task, LifecycleEventArgs $args)
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }
}
