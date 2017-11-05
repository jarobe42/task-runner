<?php

namespace Jarobe\TaskRunnerBundle\Hydrator;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

interface HydratorInterface
{
    /**
     * @param TaskEvent $taskEvent
     * @return TaskTypeInterface
     * @throws TaskException
     */
    public function getTaskFromTaskEvent(TaskEvent $taskEvent);
}
