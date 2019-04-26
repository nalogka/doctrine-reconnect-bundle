<?php

namespace Nalogka\DoctrineReconnectBundle\DependencyInjection;

use Nalogka\DoctrineReconnectBundle\DBAL\ConnectionWrapper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;

class ConnectionWrapperConfigurationCompilerPass implements CompilerPassInterface
{

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getParameter('doctrine.connections') as $connectionServiceName) {
            $def = $container->getDefinition($connectionServiceName);
            if ($def->getClass() === ConnectionWrapper::class) {
                $def->addMethodCall(
                    'setWaitBeforeRetry', 
                    [
                        new Parameter('doctrine_reconnect.wait_before_retry')
                    ]
                );
                $def->addMethodCall(
                    'setMaxRetries', 
                    [
                        new Parameter('doctrine_reconnect.max_retries')
                    ]
                );
            }
        }
    }
}