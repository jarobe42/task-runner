<?php

namespace Jarobe\TaskRunnerBundle\Command;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Manager\TaskEventManager;
use Jarobe\TaskRunnerBundle\Manager\TaskManager;
use Jarobe\TaskRunnerBundle\Model\TaskBuilder;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class TaskCommand extends AbstractTaskCommand
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $taskBuilder = new TaskBuilder();
        $taskBuilder = $this->buildTaskBuilder($taskBuilder, $input);

        $validationErrors = $this->validateTask($taskBuilder->getTask());
        foreach ($validationErrors as $validationError) {
            $taskBuilder->addError($validationError);
        }

        if ($taskBuilder->hasErrors()) {
            foreach ($taskBuilder->getErrors() as $error) {
                $output->writeln("<error>".$error."</error>");
            }
            return null;
        }

        //Create the TaskEvent
        $taskEvent = new TaskEvent();
        $taskEvent = $this->taskEventManager->createTaskEvent($taskEvent, $taskBuilder->getTask());
        $taskEvent = $this->process($taskEvent, $input, $output);
        return $taskEvent->isComplete() ? 1 : 0;
    }

    /**
     * @param TaskBuilder $taskBuilder
     * @param InputInterface $input
     * @return TaskBuilder
     */
    abstract protected function buildTaskBuilder(TaskBuilder $taskBuilder, InputInterface $input);
}
