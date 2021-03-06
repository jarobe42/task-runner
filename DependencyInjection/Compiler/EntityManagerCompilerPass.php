<?php


namespace Jarobe\TaskRunnerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EntityManagerCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $entityManagerName = $container->getParameter('jarobe.task_runner.entity_manager');
        if ($entityManagerName === null) {
            $entityManagerName = 'doctrine.orm.entity_manager';
        }
        $entityManagerReference = new Reference($entityManagerName);

        $taskEventManagerDefinition = $container->getDefinition('jarobe.task_runner.task_event_manager');
        $taskEventManagerDefinition->replaceArgument(0, $entityManagerReference);

        $taskEventRepository = $container->getDefinition('jarobe.task_runner.task_event_repository');
        $taskEventRepository->setFactory([$entityManagerReference, 'getRepository']);
    }
}
