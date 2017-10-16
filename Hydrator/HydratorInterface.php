<?php

namespace Jarobe\TaskRunner\Hydrator;

use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

interface HydratorInterface
{
    /**
     * @param TaskEvent $taskEvent
     * @return TaskTypeInterface
     * @throws TaskException
     */
    public function getTaskFromTaskEvent(TaskEvent $taskEvent);
}
