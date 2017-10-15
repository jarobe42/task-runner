<?php

namespace Jarobe\TaskRunner\Hydrator;

use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\Task\TaskTypeInterface;

interface HydratorInterface
{
    /**
     * @param TaskEvent $taskEvent
     * @return TaskTypeInterface
     * @throws TaskException
     */
    public function getTaskFromTaskEvent(TaskEvent $taskEvent);
}
