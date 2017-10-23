<?php

namespace Jarobe\TaskRunner\DependencyInjection;

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
                ->arrayNode('types')
                ->children()
                    ->scalarNode('directory')->end()
                    ->scalarNode('namespace')->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
