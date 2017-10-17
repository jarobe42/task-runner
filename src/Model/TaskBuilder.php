<?php

namespace Jarobe\TaskRunner\Model;

use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

class TaskBuilder
{
    /**
     * @var TaskTypeInterface $task
     */
    private $task;

    /**
     * @var array
     */
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * @return TaskTypeInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param TaskTypeInterface $task
     * @return TaskBuilder
     */
    public function setTask($task)
    {
        $this->task = $task;
        return $this;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $error
     * @return TaskBuilder
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        return $this;
    }
}
