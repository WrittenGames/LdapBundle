<?php

namespace WG\LdapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class WGLdapExtension extends Extension
{
    public function load( array $configs, ContainerBuilder $container )
    {
        // Configuration
        $configuration = new Configuration();
        $config = $this->processConfiguration( $configuration, $configs );
        // Services
        $fileLocator = new FileLocator( __DIR__ . '/../Resources/config' );
        $loader = new Loader\YamlFileLoader( $container, $fileLocator );
        $loader->load( 'services.yml' );
        // Set parameters
        if ( isset( $config['results_per_page'] ) )
        {
            //throw new \InvalidArgumentException( 'At least one directory server must be defined' );
        }
        echo '<pre>';
        print_r( $config );
        echo '</pre>';
        die();
        //$container->setParameter( 'wg_ldap.results_per_page', $config['results_per_page'] );
    }
}
