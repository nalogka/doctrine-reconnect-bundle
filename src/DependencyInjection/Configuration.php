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

        $treeBuilder->getRootNode()
            ->children()
            ->integerNode('healthcheck_timeout')->defaultValue(28000)->end()
            ->end();

        return $treeBuilder;
    }
}