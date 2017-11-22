<?php

namespace Jarobe\TaskRunnerBundle\Provider;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;

interface TaskEventProviderInterface
{
    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getCompletedTaskEvents(\DateTime $dateTime, $typeName);

    /**
     * @param \DateTime $dateTime
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getPendingTaskEvents(\DateTime $dateTime, $typeName);

    /**
     * @param \DateTime $dateTIme
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getScheduledTaskEvents(\DateTime $dateTIme, $typeName);

    /**
     * @param \DateTime $dateTIme
     * @param $typeName
     * @return TaskEvent|null
     */
    public function getNextScheduledTaskEvent(\DateTime $dateTIme, $typeName);

    /**
     * @param \DateTime $dateTIme
     * @param $typeName
     * @return TaskEvent[]
     */
    public function getFailedTaskEvents(\DateTime $dateTIme, $typeName);
}
