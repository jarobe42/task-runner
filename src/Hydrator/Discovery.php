<?php

namespace Jarobe\TaskRunner\Hydrator;

use Doctrine\Common\Annotations\Reader;
use Jarobe\TaskRunner\Type\TaskTypeInterface;
use Pepperstone\ReportBundle\Annotation\TaskType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Discovery implements DiscoveryInterface
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * The Kernel root directory
     * @var string
     */
    private $rootDir;

    /**
     * @var array
     */
    private $tasks = [];


    /**
     * WorkerDiscovery constructor.
     *
     * @param $namespace
     *   The namespace of the workers
     * @param $directory
     *   The directory of the workers
     * @param $rootDir
     * @param Reader $annotationReader
     */
    public function __construct($namespace, $directory, $rootDir, Reader $annotationReader)
    {
        $this->namespace = $namespace;
        $this->annotationReader = $annotationReader;
        $this->directory = $directory;
        $this->rootDir = $rootDir;
    }

    /**
     * Returns all the tasks
     */
    public function getTasks()
    {
        if (!$this->tasks) {
            $this->discoverTaskTypes();
        }

        return $this->tasks;
    }

    /**
     * Discovers tasks
     */
    private function discoverTaskTypes()
    {
        $path = $this->rootDir . '/../src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);

        $annotationClass = TaskType::class;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            /** @var TaskTypeInterface $class */
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            $classReflection = new \ReflectionClass($class);
            $annotation = $this->annotationReader->getClassAnnotation($classReflection, $annotationClass);
            if (!$annotation) {
                continue;
            }

            $name = $class::getName();

            /** @var TaskType $annotation */
            $this->tasks[$name] = $class;
        }
    }
}
