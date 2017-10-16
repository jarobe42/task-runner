<?php

namespace Jarobe\TaskRunner\Hydrator;

use Jarobe\TaskRunner\Exception\TaskException;

class Registry implements RegistryInterface
{
    private $taskClassNames;

    public function __construct(array $taskClassNames)
    {
        $this->taskClassNames = $taskClassNames;
    }

    /**
     * Returns the FQCN for a Task name
     *
     * @param $name
     * @return string
     * @throws TaskException
     */
    public function getClassByName($name)
    {
        foreach ($this->taskClassNames as $task) {
            $taskName = $task::getName();
            if ($taskName === $name) {
                return $task;
            }
        }
        throw new TaskException(
            sprintf("No Task found for name %s. You may need to add the Task to the Registry", $name)
        );
    }
}
