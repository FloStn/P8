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

    public function postPersist()
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }

    public function postUpdate()
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }

    public function postRemove()
    {
        $this->cacheDriver->expire('[tasks_all][1]', 0);
    }
}
