<?php


namespace Jarobe\TaskRunner\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class TaskType
{
    /** @Required */
    public $name;
}
