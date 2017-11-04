<?php


namespace Jarobe\TaskRunner\Hydrator;

use Doctrine\Common\Annotations\Reader;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;
use Jarobe\TaskRUnner\Annotation\TaskType;
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
     * @var Reflector
     */
    private $reflector;

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
     * @param Reflector $reflector
     */
    public function __construct($namespace, $directory, $rootDir, Reflector $reflector)
    {
        $this->namespace = $namespace;
        $this->reflector = $reflector;
        $this->directory = $directory;
        $this->rootDir = $rootDir;
    }

    /**
     * Returns all the tasks
     * @return array
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

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            /** @var TaskTypeInterface $class */
            $class = $this->namespace . '\\' . $file->getBasename('.php');

            $name = $this->reflector->getNameForClass($class);
            if (!$name) {
                continue;
            }
            /** @var TaskType $annotation */
            $this->tasks[$name] = $class;
        }
    }
}