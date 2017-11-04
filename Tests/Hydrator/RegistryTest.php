<?php


namespace Jarobe\TaskRunner\Tests\Hydrator;


use Jarobe\TaskRunner\Exception\TaskException;
use Jarobe\TaskRunner\Hydrator\DiscoveryInterface;
use Jarobe\TaskRunner\Hydrator\Registry;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Registry $registry */
    private $registry;

    public function setUp()
    {
        $tasks = [
            'valid' => TaskTypeInterface::class,
        ];
        /** @var DiscoveryInterface $discovery */
        $discovery = $this->prophesize(DiscoveryInterface::class);
        $discovery->getTasks()->willReturn($tasks);

        $this->registry = new Registry($discovery->reveal());
    }

    /**
     * @dataProvider taskTypeExamples
     * @test
     */
    public function it_gets_class($name, $isValid)
    {
        if (!$isValid) {
            $this->setExpectedException(TaskException::class);
        }
        $taskDriver = $this->registry->getClassByName($name);
        $this->assertEquals(TaskTypeInterface::class, $taskDriver);
    }

    public function taskTypeExamples()
    {
        return [
            ['valid', true],
            ['invalid', false]
        ];
    }
}