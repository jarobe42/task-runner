<?php

namespace Jarobe\TaskRunnerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class JarobeTaskRunnerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('jarobe.task_runner.entity_manager', $config['entity_manager']);
        $container->setParameter('jarobe.task_runner.types.namespace', $config['types']['namespace']);
        $container->setParameter('jarobe.task_runner.types.directory', $config['types']['directory']);

    }
}