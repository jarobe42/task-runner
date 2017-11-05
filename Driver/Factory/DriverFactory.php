<?php

namespace Jarobe\TaskRunnerBundle\Driver\Factory;

use Jarobe\TaskRunnerBundle\Driver\TaskDriverInterface;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

class DriverFactory
{
    /** @var TaskDriverInterface[] */
    private $taskDrivers;

    public function __construct(array $taskDrivers)
    {
        $this->taskDrivers = $taskDrivers;
    }

    /**
     * @param TaskTypeInterface $task
     * @return TaskDriverInterface
     * @throws TaskException
     */
    public function getDriverForTask(TaskTypeInterface $task)
    {
        $class = get_class($task);

        foreach ($this->taskDrivers as $taskDriver) {
            if ($taskDriver->supportsClass($class)) {
                return $taskDriver;
            }
        }

        throw new TaskException("No driver found for ".$class);
    }
}
