<?php

namespace Jarobe\TaskRunner\Tests\Model;

use Jarobe\TaskRunner\Model\TaskBuilder;

class TaskBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_reveal_errors()
    {
        $taskBuilder = new TaskBuilder();
        $this->assertFalse($taskBuilder->hasErrors());
        $taskBuilder->addError('This is an error');
        $this->assertTrue($taskBuilder->hasErrors());
        $taskBuilder->addError('This is another error');
        $this->assertTrue($taskBuilder->hasErrors());
    }
}