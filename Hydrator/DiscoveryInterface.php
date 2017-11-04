<?php

namespace Jarobe\TaskRunner\Hydrator;

interface DiscoveryInterface
{
    /**
     * Returns all the tasks
     * @return array
     */
    public function getTasks();
}
