<?php

namespace Jarobe\TaskRunnerBundle\Manager;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Entity\TaskEventInterface;
use Jarobe\TaskRunnerBundle\Hydrator\HydratorInterface;
use Jarobe\TaskRunnerBundle\Processor\ProcessorInterface;

/**
 * Responsible for processing a Task.
 */
class TaskManager
{
    /**
     * @var TaskEventManager
     */
    private $taskEventManager;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    public function __construct(
        TaskEventManager $taskEventManager,
        HydratorInterface $hydrator,
        ProcessorInterface $processor
    ) {
        $this->taskEventManager = $taskEventManager;
        $this->hydrator = $hydrator;
        $this->processor = $processor;
    }

    /**
     * @param TaskEventInterface $taskEvent
     * @return TaskEventInterface
     */
    public function process(TaskEventInterface $taskEvent)
    {
        $this->taskEventManager->initiateTaskEvent($taskEvent);

        $task = $this->hydrator->getTaskFromTaskEvent($taskEvent);
        $result = $this->processor->process($task);

        $this->taskEventManager->updateTaskEventWithResult($taskEvent, $result);

        return $taskEvent;
    }
}
