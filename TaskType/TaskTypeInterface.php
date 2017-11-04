<?php

namespace Jarobe\TaskRunner\TaskType;

interface TaskTypeInterface
{
    /**
     * @return \DateTime|null
     */
    public function getTargetTime();

    /**
     * @return array
     */
    public function getPayload();

    /**
     * @param array $payload
     * @return mixed
     */
    public function setFromPayload(array $payload);
}