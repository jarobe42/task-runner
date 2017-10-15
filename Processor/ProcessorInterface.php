<?php

namespace Pepperstone\ReportBundle\Task\Processor;

use Jarobe\TaskRunner\Model\TaskResult;
use Jarobe\TaskRunner\Task\TaskTypeInterface;

interface ProcessorInterface
{
    /**
     * @param TaskTypeInterface $task
     * @return TaskResult
     */
    public function process(TaskTypeInterface $task);
}
