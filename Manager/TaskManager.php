<?php

namespace Jarobe\TaskRunner\Manager;

use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Hydrator\HydratorInterface;
use Pepperstone\ReportBundle\Task\Processor\ProcessorInterface;

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
     * @param TaskEvent $taskEvent
     * @return TaskEvent
     */
    public function process(TaskEvent $taskEvent)
    {
        $this->taskEventManager->initiateTaskEvent($taskEvent);

        $task = $this->hydrator->getTaskFromTaskEvent($taskEvent);
        $result = $this->processor->process($task);

        $this->taskEventManager->updateTaskEventWithResult($taskEvent, $result);

        return $taskEvent;
    }
}
