<?php

namespace Pepperstone\ReportBundle\Task\Processor;

use Jarobe\TaskRunner\Model\TaskResult;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

interface ProcessorInterface
{
    /**
     * Takes a task and attempts to process it. WIll set the result of the Task.
     *
     * @param TaskTypeInterface $task
     * @return TaskResult
     */
    public function process(TaskTypeInterface $task);
}
