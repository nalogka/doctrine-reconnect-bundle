<?php

namespace Nalogka\DoctrineReconnectBundle;

use Nalogka\DoctrineReconnectBundle\DependencyInjection\ConnectionWrapperConfigurationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineReconnectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ConnectionWrapperConfigurationCompilerPass());
    }
}