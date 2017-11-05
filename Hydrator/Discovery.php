<?php


namespace Jarobe\TaskRunnerBundle\Hydrator;

use Doctrine\Common\Annotations\Reader;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;
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
     * The Kernel root directory
     * @var string
     */
    private $rootDir;

    /**
     * @var array|null
     */
    private $tasks;


    /**
     * WorkerDiscovery constructor.
     *
     * @param $namespace
     *   The namespace of the workers
     * @param $directory
     *   The directory of the workers
     * @param $rootDir
     */
    public function __construct($namespace, $directory, $rootDir)
    {
        $this->namespace = $namespace;
        $this->directory = $directory;
        $this->rootDir = $rootDir;
        $this->tasks = null;
    }

    /**
     * Returns all the tasks
     * @return array
     */
    public function getTasks()
    {
        if ($this->tasks === null) {
            $this->tasks = $this->discoverTaskTypes();
        }

        return $this->tasks;
    }

    /**
     * Discovers tasks
     * @return array $tasks
     */
    private function discoverTaskTypes()
    {
        $path = $this->rootDir . '/../src/' . $this->directory;
        $finder = new Finder();
        $finder->files()->in($path);

        $tasks = [];
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            /** @var TaskTypeInterface $class */
            $class = $this->namespace . '\\' . $file->getBasename('.php');

            if (!$class instanceof TaskTypeInterface) {
                continue;
            }

            $name = $class::getName();

            /** @var TaskType $annotation */
            $tasks[$name] = $class;
        }
        return $tasks;
    }
}