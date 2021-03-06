<?php

namespace Jarobe\TaskRunnerBundle\Hydrator;

use Jarobe\TaskRunnerBundle\Exception\TaskException;

class Registry implements RegistryInterface
{
    private $discoverer;

    public function __construct(DiscoveryInterface $taskDiscoverer)
    {
        $this->discoverer = $taskDiscoverer;
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
        $taskClasses = $this->discoverer->getTasks();

        if (!isset($taskClasses[$name])) {
            throw new TaskException(
                sprintf("No Task found for name %s. You may need to add the Task to the Registry", $name)
            );
        }

        return $taskClasses[$name];
    }
}

