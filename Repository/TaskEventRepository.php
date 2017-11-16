<?php


namespace Jarobe\TaskRunnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Jarobe\TaskRunnerBundle\Entity\TaskEvent;

class TaskEventRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateTime
     * @param $taskName
     * @return TaskEvent[]
     */
    public function getCompletedTaskEvents(\DateTime $dateTime, $taskName)
    {
        $qb = $this->createQueryBuilder('te');
        $qb->andWhere('te.taskName = :taskName')
            ->andWhere('te.targetTime = :targetTime')
            ->andWhere('te.completedAt IS NOT NULL')
        ;
        $qb->setParameter('taskName', $taskName)
            ->setParameter('targetTime', $dateTime)
        ;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param \DateTime $dateTime
     * @param $taskName
     * @return TaskEvent[]
     */
    public function getFailedTaskEvents(\DateTime $dateTime, $taskName)
    {
        $qb = $this->createQueryBuilder('te');
        $qb->andWhere('te.taskName = :taskName')
            ->andWhere('te.targetTime = :targetTime')
            ->andWhere('te.failedAt IS NOT NULL')
        ;
        $qb->setParameter('taskName', $taskName)
            ->setParameter('targetTime', $dateTime)
        ;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param \DateTime $dateTime
     * @param $taskName
     * @return TaskEvent[]
     */
    public function getPendingTaskEvents(\DateTime $dateTime, $taskName)
    {
        $qb = $this->createQueryBuilder('te');
        $qb->andWhere('te.taskName = :taskName')
            ->andWhere('te.targetTime = :targetTime')
            ->andWhere('te.completedAt IS NULL')
            ->andWhere('te.failedAt IS NULL')
            ->andWhere('te.initiatedAt IS NOT NULL')
        ;
        $qb->setParameter('taskName', $taskName)
            ->setParameter('targetTime', $dateTime)
        ;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param \DateTime $dateTime
     * @param $taskName
     * @return TaskEvent[]
     */
    public function getScheduledTaskEvents(\DateTime $dateTime, $taskName)
    {
        $qb = $this->createQueryBuilder('te');
        $qb->andWhere('te.taskName = :taskName')
            ->andWhere('te.targetTime = :targetTime')
            ->andWhere('te.initiatedAt IS NULL')
        ;
        $qb->setParameter('taskName', $taskName)
            ->setParameter('targetTime', $dateTime)
        ;

        $qb->addOrderBy('te.id', 'ASC');

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
