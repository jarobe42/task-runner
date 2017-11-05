<?php

namespace Jarobe\TaskRunnerBundle\Model;

class TaskResult
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var array
     */
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return TaskResult
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return TaskResult
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }
}
