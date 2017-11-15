<?php

namespace Jarobe\TaskRunnerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Entity\TaskEventInterface;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\Hydrator\Reflector;
use Jarobe\TaskRunnerBundle\Model\TaskResult;
use Jarobe\TaskRunnerBundle\Provider\TaskEventProviderInterface;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

class TaskEventManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Reflector
     */
    private $reflector;

    public function __construct(EntityManager $entityManager, Reflector $reflector)
    {
        $this->entityManager = $entityManager;
        $this->reflector = $reflector;
    }

    /**
     * @param TaskEventInterface $taskEventInterface
     * @param TaskTypeInterface $task
     * @return TaskEventInterface
     */
    public function createTaskEvent(TaskEventInterface $taskEventInterface, TaskTypeInterface $task)
    {
        $name = $this->reflector->getNameForClass($task);

        $taskEventInterface->intialize($name, $task);

        $this->entityManager->persist($taskEventInterface);
        $this->entityManager->flush($taskEventInterface);
        return $taskEventInterface;
    }

    /**
     * @param TaskEventInterface $taskEvent
     * @return TaskEventInterface
     */
    public function initiateTaskEvent(TaskEventInterface $taskEvent)
    {
        $taskEvent->initiate();

        $this->entityManager->flush($taskEvent);

        return $taskEvent;
    }

    /**
     * @param TaskEventInterface $taskEvent
     * @param TaskResult $result
     * @return TaskEventInterface
     */
    public function updateTaskEventWithResult(TaskEventInterface $taskEvent, TaskResult $result)
    {
        if ($result->isSuccess()) {
            $taskEvent->setAsCompleted();
        } else {
            $taskEvent->setAsFailed($result->getErrors());
        }
        $this->entityManager->flush($taskEvent);
        return $taskEvent;
    }
}
