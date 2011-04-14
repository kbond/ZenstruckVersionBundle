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

        $container->getDefinition('zenstruck.version.data_collector')
                ->setArgument(0, $config['file']);

        if ($config['helper'])
            $loader->load('helper.xml');

        if ($config['twig'])
            $loader->load('twig.xml');

        if (!$config['toolbar'])
            $container->getDefinition('zenstruck.version.data_collector')->setTags(array());

        if (isset($config['block']) && $config['block']['enabled']) {
            $loader->load('block.xml');
            $container->getDefinition('zenstruck.version.block')
                ->setArgument(1, $config['block']['position'])
                ->setArgument(2, $config['block']['prefix']);
        }        
    }

}
