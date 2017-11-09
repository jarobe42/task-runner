<?php

namespace Jarobe\TaskRunnerBundle\Command;

use Jarobe\TaskRunnerBundle\Entity\TaskEvent;
use Jarobe\TaskRunnerBundle\Entity\TaskEventInterface;
use Jarobe\TaskRunnerBundle\Manager\TaskEventManager;
use Jarobe\TaskRunnerBundle\Manager\TaskManager;
use Jarobe\TaskRunnerBundle\Model\TaskBuilder;
use Jarobe\TaskRunnerBundle\TaskType\TaskTypeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractTaskCommand extends ContainerAwareCommand
{
    /** @var TaskEventManager */
    protected $taskEventManager;

    /** @var TaskManager */
    protected $taskManager;

    /** @var ValidatorInterface */
    protected $validator;

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $container = $this->getContainer();
        $this->taskEventManager = $container->get('jarobe.task_runner.task_event_manager');
        $this->taskManager = $container->get('jarobe.task_runner.task_manager');
        $this->validator = $container->get('validator');
    }

    /**
     * @param TaskEventInterface $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return TaskEvent
     */
    protected function process(TaskEventInterface $taskEvent, InputInterface $input, OutputInterface $output)
    {
        $this->preProcess($taskEvent, $input, $output);

        $taskEvent = $this->taskManager->process($taskEvent);

        $this->postProcess($taskEvent, $input, $output);

        return $taskEvent;
    }

    /**
     * Overwrite this function if you want to do something before we process the TaskEvent
     * @param TaskEventInterface $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function preProcess(TaskEventInterface $taskEvent, InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * Overwrite this function if you want to do something after we process the TaskEvent
     * @param TaskEventInterface $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function postProcess(TaskEventInterface $taskEvent, InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * @param TaskTypeInterface $task
     * @return array
     */
    protected function validateTask(TaskTypeInterface $task)
    {
        $validationErrors = [];
        $validationErrorList = $this->validator->validate($task);
        /** @var ConstraintViolationInterface $error */
        foreach ($validationErrorList as $error) {
            $validationErrors[] = sprintf("%s: %s", $error->getPropertyPath(), $error->getMessage());
        }
        return $validationErrors;
    }
}
