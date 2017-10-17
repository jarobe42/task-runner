<?php

namespace Jarobe\TaskRunner\Hydrator;

use Jarobe\TaskRunner\Exception\TaskException;

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
