<?php

namespace Jarobe\TaskRunner\Command;

use Jarobe\TaskRunner\Entity\TaskEvent;
use Jarobe\TaskRunner\Manager\TaskEventManager;
use Jarobe\TaskRunner\Manager\TaskManager;
use Jarobe\TaskRunner\Model\TaskBuilder;
use Jarobe\TaskRunner\TaskType\TaskTypeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class TaskCommand extends ContainerAwareCommand
{
    /** @var TaskEventManager */
    private $taskEventManager;

    /** @var TaskManager */
    private $taskManager;

    /** @var ValidatorInterface */
    private $validator;

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $container = $this->getContainer();
        $this->taskEventManager = $container->get('jarobe.task_runner.task_event_manager');
        $this->taskManager = $container->get('jarobe.task_runner.task_manager');
        $this->validator = $container->get('validator');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return TaskEvent
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $taskBuilder = new TaskBuilder();

        $taskBuilder = $this->buildTaskBuilder($taskBuilder, $input);

        $validationErrors = $this->validateTask($taskBuilder->getTask());
        foreach($validationErrors as $validationError){
            $taskBuilder->addError($validationError);
        }

        if ($taskBuilder->hasErrors()) {
            foreach ($taskBuilder->getErrors() as $error) {
                $output->writeln("<error>".$error."</error>");
            }
            return null;
        }

        //Create the TaskEvent
        $taskEvent = $this->taskEventManager->createTaskEvent($taskBuilder->getTask());

        $this->preProcess($taskEvent, $input, $output);

        $taskEvent = $this->taskManager->process($taskEvent);

        $this->postProcess($taskEvent, $input, $output);

        return $taskEvent;
    }

    /**
     * @param TaskBuilder $taskBuilder
     * @param InputInterface $input
     * @return TaskBuilder
     */
    abstract protected function buildTaskBuilder(TaskBuilder $taskBuilder, InputInterface $input);

    /**
     * Overwrite this function if you want to do something before we process the TaskEvent
     * @param TaskEvent $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function prepareTaskEvent(TaskEvent $taskEvent, InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * Overwrite this function if you want to do something before we process the TaskEvent
     * @param TaskEvent $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function preProcess(TaskEvent $taskEvent, InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * Overwrite this function if you want to do something before we process the TaskEvent
     * @param TaskEvent $taskEvent
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function postProcess(TaskEvent $taskEvent, InputInterface $input, OutputInterface $output)
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
        foreach($validationErrorList as $error){
            $validationErrors[] = sprintf("%s: %s", $error->getPropertyPath(), $error->getMessage());
        }
        return $validationErrors;
    }
}
