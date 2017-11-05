<?php

namespace Jarobe\TaskRunnerBundle\Processor;

use Jarobe\TaskRunnerBundle\Model\TaskResult;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

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
