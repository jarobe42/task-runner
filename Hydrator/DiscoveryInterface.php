<?php

namespace Jarobe\TaskRunnerBundle\Hydrator;

interface DiscoveryInterface
{
    /**
     * Returns all the tasks
     * @return array
     */
    public function getTasks();
}
