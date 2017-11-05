<?php


namespace Jarobe\TaskRunnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="task_event")
 * @ORM\Entity()
 */
class TaskEvent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="task_name", type="string", length=100)
     */
    private $taskName;


    /**
     * Many of the Tasks that are run have a specified time that they run for. Because of this, we store the TargetTime
     * outside of the payload. This helps significantly with querying what commands have been run for a date, as well.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="target_time", type="datetime", nullable=true)
     */
    private $targetTime;

    /**
     * @var array
     *
     * @ORM\Column(name="payload", type="array")
     */
    private $payload;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="initiated_at", type="datetime", nullable=true)
     */
    private $initiatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="failed_at", type="datetime", nullable=true)
     */
    private $failedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="completed_at", type="datetime", nullable=true)
     */
    private $completedAt;

    /**
     * @var array|null
     *
     * @ORM\Column(name="errors", type="json_array", nullable=true)
     */
    private $errors;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * @param string $taskName
     * @return TaskEvent
     */
    public function setTaskName($taskName)
    {
        $this->taskName = $taskName;
        return $this;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return TaskEvent
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInitiatedAt()
    {
        return $this->initiatedAt;
    }

    /**
     * @param \DateTime $initiatedAt
     * @return TaskEvent
     */
    public function setInitiatedAt(\DateTime $initiatedAt)
    {
        $this->initiatedAt = $initiatedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * @param \DateTime $completedAt
     * @return TaskEvent
     */
    public function setCompletedAt(\DateTime $completedAt)
    {
        $this->completedAt = $completedAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFailedAt()
    {
        return $this->failedAt;
    }

    /**
     * @param $failedAt
     * @return $this
     */
    public function setFailedAt(\DateTime $failedAt)
    {
        $this->failedAt = $failedAt;
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
     * @param array|null $errors
     * @return $this
     */
    public function setErrors(array $errors = null)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTargetTime()
    {
        return $this->targetTime;
    }

    /**
     * @param \DateTime $targetTime
     * @return $this
     */
    public function setTargetTime($targetTime = null)
    {
        $this->targetTime = $targetTime;

        return $this;
    }
}
