<?php

namespace MadrakIO\PersistentCommandBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('madrak_io_persistent_command');

        $rootNode
            ->children()
                ->scalarNode('console_node_class')
                    ->info('The classpath that should be used for the ConsoleNode entity.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('console_node_process_class')
                    ->info('The classpath that should be used for the ConsoleNodeProcess entity.')
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
