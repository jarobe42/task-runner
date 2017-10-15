<?php

namespace Jarobe\TaskRunner\Hydrator;

use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\Task\TaskTypeInterface;

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

        if(!$task instanceof TaskTypeInterface){
            $error = sprintf("Invalid Task Event provided. %s is not a valid task", $className);
            throw new TaskException($error);
        }

        $task->setFromPayload($taskEvent->getPayload());

        return $task;
    }
}
