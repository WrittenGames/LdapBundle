<?php

namespace WG\LdapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root( 'wg_ldap' );
        $this->addDirectorySection( $node );
        $this->addAuthenticationSection( $node );
        return $treeBuilder;
    }
    
    private function addDirectorySection( ArrayNodeDefinition $node )
    {
        $node
            ->children()
                ->arrayNode( 'directories' )
                    ->defaultValue(
                        array(
                            'default' => array(
                                'servers' => array(
                                    'primary' => array(
                                        'host' => 'localhost',
                                        'port' => 389
                                    )
                                ),
                                'protocol_version' => 3,
                                'referrals' => 0,
                                'network_timeout' => 20,
                            ),
                        )
                    )
                    ->addDefaultsIfNotSet()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey( 'id' )
                    ->prototype( 'array' )
                        ->children()
                            ->arrayNode( 'servers' )
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey( 'id' )
                                ->prototype( 'array' )
                                    ->children()
                                        ->scalarNode( 'host' )->cannotBeEmpty()->isRequired()->end()
                                        ->scalarNode( 'port' )->cannotBeEmpty()->defaultValue( 389 )->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode( 'protocol_version' )->defaultValue( 3 )->end()
                            ->scalarNode( 'referrals' )->defaultValue( 0 )->end()
                            ->scalarNode( 'network_timeout' )->defaultValue( 20 )->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode( 'default_directory' )->cannotBeEmpty()->defaultValue( 'default' )->cannotBeEmpty()->end()
            ->end()
        ;
    }
    
    private function addAuthenticationSection( ArrayNodeDefinition $node )
    {
        $node
            ->children()
                ->arrayNode( 'authentication' )
                    ->children()
                        ->scalarNode( 'directory' )->cannotBeEmpty()->defaultValue( 'default' )->end()
                        ->scalarNode( 'user_manager' )->cannotBeEmpty()->isRequired()->end()
                    ->end()
                ->end()
            ->end();
    }
}
