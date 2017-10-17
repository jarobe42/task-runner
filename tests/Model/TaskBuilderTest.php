<?php

namespace Tests\Jarobe\TaskRunner\Model;

use Jarobe\TaskRunner\Model\TaskBuilder;

final class TaskBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testItDeclaresErrors()
    {
        $taskBuilder = new TaskBuilder();

        $this->assertFalse($taskBuilder->hasErrors());

        $error = "error one";
        $taskBuilder->addError($error);
        $this->assertTrue($taskBuilder->hasErrors());

        $error = "error two";
        $taskBuilder->addError($error);
        $this->assertTrue($taskBuilder->hasErrors());
    }
}
