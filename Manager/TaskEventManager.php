<?php

namespace Jarobe\TaskRunner\Manager;

use Doctrine\ORM\EntityManager;
use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\Hydrator\Reflector;
use Jarobe\TaskRunner\Model\TaskResult;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

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
     * @param TaskTypeInterface $task
     * @return TaskEvent
     * @throws TaskException
     */
    public function createTaskEvent(TaskTypeInterface $task)
    {
        $taskName = $this->reflector->getNameForClass($task);

        if ($taskName === null){
            throw new TaskException(
                sprintf("No Task type found for task %s", get_class($task))
            );
        }

        $taskEvent = new TaskEvent();
        $taskEvent->setTaskName($taskName)
            ->setTargetTime($task->getTargetTime())
            ->setPayload($task->getPayload())
        ;

        $this->entityManager->persist($taskEvent);
        $this->entityManager->flush($taskEvent);
        return $taskEvent;
    }

    /**
     * @param TaskEvent $taskEvent
     * @return TaskEvent
     */
    public function initiateTaskEvent(TaskEvent $taskEvent)
    {
        $now = new \DateTime('now');
        $taskEvent->setInitiatedAt($now);

        $this->entityManager->flush($taskEvent);

        return $taskEvent;
    }

    /**
     * @param TaskEvent $taskEvent
     * @param TaskResult $result
     * @return TaskEvent
     */
    public function updateTaskEventWithResult(TaskEvent $taskEvent, TaskResult $result)
    {
        $now = new \DateTime('now');
        if ($result->isSuccess()) {
            $taskEvent->setCompletedAt($now)
                ->setErrors(null)
            ;
        } else {
            $taskEvent->setFailedAt($now)
                ->setErrors($result->getErrors())
            ;
        }
        $this->entityManager->flush($taskEvent);
        return $taskEvent;
    }
}
