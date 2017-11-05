<?php


namespace Jarobe\TaskRunnerBundle\Hydrator;


use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

class Reflector
{
    /**
     * @param TaskTypeInterface $taskType
     * @return string
     */
    public function getNameForClass(TaskTypeInterface $taskType)
    {
        return $taskType::getName();
    }
}