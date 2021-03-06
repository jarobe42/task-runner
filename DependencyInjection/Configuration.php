<?php


namespace Jarobe\TaskRunnerBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jarobe_task_runner');
        $rootNode
            ->children()
                ->scalarNode('entity_manager')->end()
                ->arrayNode('types')
                    ->isRequired()
                    ->children()
                        ->scalarNode('directory')->isRequired()->end()
                        ->scalarNode('namespace')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}