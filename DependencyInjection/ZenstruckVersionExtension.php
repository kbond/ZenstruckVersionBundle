<?php

namespace Zenstruck\VersionBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class ZenstruckVersionExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        if (!$config['enabled'])
            return;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('version.xml');

        $container->getDefinition('zenstruck.version.manager')
                ->setArgument(0, $config['file']);

        if ($config['block']['enabled']) {
            $loader->load('block.xml');
            $container->getDefinition('zenstruck.version.block')
                ->setArgument(2, $config['block']['position'])
                ->setArgument(3, $config['block']['prefix']);
        }        
    }

}
