<?php

namespace Nalogka\DoctrineReconnectBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DoctrineReconnectExtension extends Extension
{

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('doctrine_reconnect.seconds_between_pings', $config['seconds_between_pings']);
    }
}