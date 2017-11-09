<?php


namespace Jarobe\TaskRunnerBundle\Tests\Manager;

use Doctrine\ORM\EntityManager;
use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\Hydrator\Reflector;
use Jarobe\TaskRunnerBundle\Manager\TaskEventManager;
use Jarobe\TaskRunnerBundle\Model\TaskResult;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;
use Prophecy\Prophecy\ObjectProphecy;

class TaskEventManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaskEventManager $taskEventManager */
    private $taskEventManager;

    /** @var Reflector $reflector */
    private $reflector;

    public function setUp()
    {
        $entityManager = $this->prophesize(EntityManager::class);
        $this->reflector = $this->prophesize(Reflector::class);

        $this->taskEventManager = new TaskEventManager($entityManager->reveal(), $this->reflector->reveal());
    }

    /**
     * @test
     */
    public function it_should_create_a_task_event()
    {
        $payload = [];
        $targetTime = new \DateTime('2000-01-01 00:00:00');
        $taskTypeName = "valid";

        /** @var TaskTypeInterface $taskType */
        $taskType = $this->prophesize(TaskTypeInterface::class);
        $taskType->getTargetTime()->willReturn($targetTime);
        $taskType->getPayload()->willReturn($payload);

        $this->reflector->getNameForClass($taskType)->willReturn($taskTypeName);

        $taskEvent = new TaskEvent();
        $taskEvent = $this->taskEventManager->createTaskEvent($taskEvent, $taskType->reveal());

        $this->assertEquals($taskTypeName, $taskEvent->getTaskName());
        $this->assertEquals($targetTime, $taskEvent->getTargetTime());
    }

    /**
     * @test
     */
    public function it_should_initiate_a_task_event()
    {
        $taskEvent = new TaskEvent();

        $this->assertNull($taskEvent->getInitiatedAt());
        $now = new \DateTime('now');
        $this->taskEventManager->initiateTaskEvent($taskEvent);
        $this->assertGreaterThanOrEqual($now, $taskEvent->getInitiatedAt());
    }

    /**
     * @dataProvider resultExamples
     * @test
     */
    public function it_should_update_a_task_event_with_result($success, $errors, $expectedSuccess, $count)
    {
        $taskEvent = new TaskEvent();

        $taskResult = new TaskResult();
        $taskResult->setSuccess($success)
            ->setErrors($errors)
        ;
        $now = new \DateTime();

        $taskEvent = $this->taskEventManager->updateTaskEventWithResult($taskEvent, $taskResult);

        if ($expectedSuccess) {
            $this->assertGreaterThanOrEqual($now, $taskEvent->getCompletedAt());
            $this->assertNull($taskEvent->getErrors());
        } else {
            $this->assertGreaterThanOrEqual($expectedSuccess, $taskEvent->getFailedAt());
            $this->assertCount($count, $taskEvent->getErrors());
        }
    }

    public function resultExamples()
    {
        return [
            [true, [], true, null],
            [true, ['error'], true, null],
            [false, ['error'], false, 1],
            [false, [], false, 0],
        ];
    }
}
