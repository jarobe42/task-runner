<?php


namespace Jarobe\TaskRunnerBundle\Entity;

use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;

interface TaskEventInterface
{
    /**
     * @return string
     */
    public function getTaskName();

    /**
     * @return array
     */
    public function getPayload();

    /**
     * @return \DateTime
     */
    public function getTargetTime();

    /**
     * @param $name
     * @param TaskTypeInterface $taskType
     * @return TaskEventInterface
     */
    public function intialize($name, TaskTypeInterface $taskType);

    /**
     * @return TaskEventInterface
     */
    public function initiate();

    /**
     * @return TaskEventInterface
     */
    public function setAsCompleted();

    /**
     * @param array $errors
     */
    public function setAsFailed(array $errors);

    /** @return bool */
    public function isComplete();

    /** @return bool */
    public function isFailed();
}
