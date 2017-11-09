<?php


namespace Jarobe\TaskRunnerBundle\Provider;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Repository\TaskEventRepository;

class TaskEventProvider implements TaskEventProviderInterface
{
    private $repository;

    public function __construct(TaskEventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getCompletedTaskEvents(\DateTime $dateTime, $typeName)
    {
        return $this->repository->getCompletedTaskEvents($dateTime, $typeName);
    }

    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getPendingTaskEvents(\DateTime $dateTime, $typeName)
    {
        return $this->repository->getPendingTaskEvents($dateTime, $typeName);
    }

    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getScheduledTaskEvents(\DateTime $dateTime, $typeName)
    {
        return $this->repository->getScheduledTaskEvents($dateTime, $typeName);
    }

    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent|null
     */
    public function getNextScheduledTaskEvent(\DateTime $dateTime, $typeName)
    {
        $scheduled = $this->getScheduledTaskEvents($dateTime, $typeName);
        if (count($scheduled)) {
            return $scheduled[0];
        }
        return null;
    }
}
