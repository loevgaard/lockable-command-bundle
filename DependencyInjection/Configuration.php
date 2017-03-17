<?php
namespace Loevgaard\LockableCommandBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('loevgaard_lockable_command');

        $rootNode
            ->children()
                ->scalarNode('lock_dir')->defaultValue('')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}