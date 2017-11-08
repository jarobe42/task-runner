<?php


namespace Jarobe\TaskRunnerBundle\Tests\Processor;


use Jarobe\TaskRunnerBundle\Driver\Factory\DriverFactory;
use Jarobe\TaskRunnerBundle\Driver\TaskDriverInterface;
use Jarobe\TaskRunnerBundle\Exception\TaskException;
use Jarobe\TaskRunnerBundle\Model\TaskResult;
use Jarobe\TaskRunnerBundle\Processor\Processor;
use Jarobe\TaskRunnerBundle\Processor\ProcessorInterface;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;
use Prophecy\Prophecy\ObjectProphecy;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var DriverFactory|ObjectProphecy */
    private $driverFactory;

    /** @var Processor */
    private $processor;

    public function setUp()
    {
        $this->driverFactory = $this->prophesize(DriverFactory::class);
        $this->processor = new Processor($this->driverFactory->reveal());
    }

    /**
     * @test
     * @dataProvider processExamples
     */
    public function it_can_process_tasks(
        $success,
        array $validationErrors,
        array $runErrors
    )
    {
        /** @var TaskDriverInterface|ObjectProphecy $driver */
        $driver = $this->prophesize(TaskDriverInterface::class);

        /** @var TaskTypeInterface|ObjectProphecy $task */
        $task = $this->prophesize(TaskTypeInterface::class);

        //Try for a driver
        $driver->canRun($task->reveal())->willReturn($validationErrors);
        $driver->run($task->reveal())->willReturn($runErrors);

        $this->driverFactory->getDriverForTask($task->reveal())->willReturn($driver->reveal());

        $result = $this->processor->process($task->reveal());
        $this->assertInstanceOf(TaskResult::class, $result);
        $this->assertEquals($success, $result->isSuccess());

        if (count($validationErrors) > 0) {
            $this->assertEquals($validationErrors, $result->getErrors());
        } else {
            $this->assertEquals($runErrors, $result->getErrors());
        }
    }

    public function processExamples()
    {
        return [
            [true, [], []],
            [false, ['error'], []],
            [false, [], ['error']],
            [false, ['error'], ['error']]
        ];
    }

    /**
     * @test
     */
    public function it_handles_an_unsupported_task()
    {
        /** @var TaskTypeInterface|ObjectProphecy $task */
        $task = $this->prophesize(TaskTypeInterface::class);

        //Try for a driver that doesn't exist
        $this->driverFactory->getDriverForTask($task->reveal())->willThrow(TaskException::class);

        $result = $this->processor->process($task->reveal());
        $this->assertInstanceOf(TaskResult::class, $result);
        $this->assertEquals(false, $result->isSuccess());
        $this->assertCount(1, $result->getErrors());
    }
}
