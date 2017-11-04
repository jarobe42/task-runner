<?php


namespace Jarobe\TaskRunner\Hydrator;

use Doctrine\Common\Annotations\Reader;
use Jarobe\TaskRunner\Annotation\TaskType as TaskTypeAnnotation;

class Reflector
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param $class
     * @return null
     */
    public function getNameForClass($class)
    {
        $annotation = $this->loadAnnotation($class);

        if ($annotation === null) {
            return null;
        }
        return $annotation->name;
    }

    /**
     * @param $class
     * @return TaskTypeAnnotation|null
     */
    protected function loadAnnotation($class)
    {
        $annotationClass = TaskTypeAnnotation::class;

        $classReflection = new \ReflectionClass($class);
        /** @var TaskTypeAnnotation $annotation */
        $annotation = $this->annotationReader->getClassAnnotation($classReflection, $annotationClass);
        return $annotation;
    }
}