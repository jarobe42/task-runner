<?php

namespace Jarobe\TaskRunnerBundle;

use Jarobe\TaskRunnerBundle\DependencyInjection\Compiler\DriverCompilerPass;
use Jarobe\TaskRunnerBundle\DependencyInjection\Compiler\EntityManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JarobeTaskRunnerBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DriverCompilerPass());
        $container->addCompilerPass(new EntityManagerCompilerPass());
    }
}