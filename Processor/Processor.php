<?php

namespace Pepperstone\ReportBundle\Task\Processor;

use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\Model\TaskResult;
use Jarobe\TaskRunner\Driver\Factory\DriverFactory;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

class Processor implements ProcessorInterface
{
    /**
     * @var DriverFactory
     */
    private $driverFactory;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driverFactory = $driverFactory;
    }

    /**
     * @param TaskTypeInterface $task
     * @return TaskResult
     */
    public function process(TaskTypeInterface $task)
    {
        $taskResult = new TaskResult();

        try {
            $driver = $this->driverFactory->getDriverForTask($task);
        } catch (TaskException $e) {
            $exceptionMessage = sprintf("TaskException: %s", $e->getMessage());
            $taskResult->setSuccess(false)
                ->setErrors([$exceptionMessage])
            ;
            return $taskResult;
        }


        //See if there's any issues with the tasks before running.
        $validationErrors = $driver->canRun($task);
        if (count($validationErrors) > 0) {
            $taskResult->setSuccess(false)
                ->setErrors($validationErrors)
            ;
            return $taskResult;
        }

        //Run the task, and then check for errors
        $errors = $driver->run($task);
        if (count($errors) > 0) {
            $taskResult->setSuccess(false)
                ->setErrors($errors)
            ;
            return $taskResult;
        }

        $taskResult->setSuccess(true);
        return $taskResult;
    }
}
