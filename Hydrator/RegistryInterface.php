<?php

namespace Jarobe\TaskRunnerBundle\Hydrator;

use Jarobe\TaskRunnerBundle\Exception\TaskException;

interface RegistryInterface
{
    /**
     * Returns the FQCN for a Task name
     *
     * @param $name
     * @return string
     * @throws TaskException
     */
    public function getClassByName($name);
}
