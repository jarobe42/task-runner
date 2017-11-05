<?php

namespace Jarobe\TaskRunnerBundle\Driver;

use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

interface TaskDriverInterface
{
    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class);

    /**
     * Used as runtime validation - ensures that all dependencies are met and that there are no blockers
     *
     * @param TaskTypeInterface $task
     * @return array|null
     */
    public function canRun(TaskTypeInterface $task);

    /**
     * @param TaskTypeInterface $task
     * @return array|null
     */
    public function run(TaskTypeInterface $task);
}
