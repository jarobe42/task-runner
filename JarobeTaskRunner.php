<?php

namespace Jarobe\TaskRunner;

use Jarobe\TaskRunner\DependencyInjection\Compiler\EntityManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JarobeTaskRunner extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new EntityManagerCompilerPass());
    }
}