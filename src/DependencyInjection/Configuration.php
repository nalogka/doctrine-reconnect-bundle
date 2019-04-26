<?php

namespace Nalogka\DoctrineReconnectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('doctrine_reconnect');

        $treeBuilder->root('doctrine_reconnect')
            ->children()
            ->integerNode('max_retries')->defaultValue(12)->end()
            ->integerNode('wait_before_retry')->defaultValue(333333)->end()
            ->end();

        return $treeBuilder;
    }
}