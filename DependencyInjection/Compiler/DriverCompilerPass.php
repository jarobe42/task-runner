<?php


namespace Jarobe\TaskRunnerBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DriverCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tagName = 'jarobe.task_runner.driver';
        $factoryServiceName = 'jarobe.task_runner.driver_factory';

        if (!$container->has($factoryServiceName)) {
            return;
        }

        $definition = $container->findDefinition($factoryServiceName);
        $taggedServices = $container->findTaggedServiceIds($tagName);

        $drivers = [];
        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the ChainTransport service
            $drivers[] = new Reference($id);
        }

        $definition->replaceArgument(0, $drivers);

    }
}