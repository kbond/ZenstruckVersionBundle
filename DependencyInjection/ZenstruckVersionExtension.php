<?php

namespace Zenstruck\Bundle\VersionBundle\DependencyInjection;

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

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('version.xml');
        $loader->load('helper.xml');
        $loader->load('twig.xml');

        if ($config['version'])
            $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(1, $config['version']);
        else
        {
            if ($config['file'])
                $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(0, $config['file']);

            if ($config['text'])
                $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(1, $config['text']);
        }

        if (!$config['toolbar'])
            $container->getDefinition('zenstruck.version.data_collector')->setTags(array());

        if (isset($config['block']) && $config['block']['enabled'])
        {
            $loader->load('block.xml');
            $container->getDefinition('zenstruck.version.block')
                    ->replaceArgument(1, $config['block']['position'])
                    ->replaceArgument(2, $config['block']['prefix']);
        }
    }

}
