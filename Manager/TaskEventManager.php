<?php

namespace Jarobe\TaskRunnerBundle\Manager;

use Doctrine\ORM\EntityManager;
use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\Hydrator\Reflector;
use Jarobe\TaskRunnerBundle\Model\TaskResult;
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

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param TaskTypeInterface $task
     * @return TaskEvent
     * @throws TaskException
     */
    public function createTaskEvent(TaskTypeInterface $task)
    {
        $taskEvent = new TaskEvent();
        $taskEvent->setTaskName($task::getName())
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
