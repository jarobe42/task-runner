<?php

namespace Jarobe\TaskRunnerBundle\Hydrator;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

class Hydrator implements HydratorInterface
{
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param TaskEvent $taskEvent
     * @return TaskTypeInterface
     * @throws TaskException
     */
    public function getTaskFromTaskEvent(TaskEvent $taskEvent)
    {
        $className = $this->registry->getClassByName($taskEvent->getTaskName());

        /** @var TaskTypeInterface $task */
        $task = new $className();

        if (!$task instanceof TaskTypeInterface) {
            $error = sprintf("Invalid Task Event provided. %s is not a valid task", $className);
            throw new TaskException($error);
        }

        $task->setFromPayload($taskEvent->getPayload());

        return $task;
    }
}
