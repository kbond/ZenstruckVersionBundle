<?php

namespace Zenstruck\Bundle\VersionBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\Kernel;
use Zenstruck\Bundle\VersionBundle\ZenstruckVersionBundle;

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

        if (version_compare(ZenstruckVersionBundle::getSymfonyVersion(Kernel::VERSION), '2.1.0', '<')) {
            $tagForOldSymfony = array (
                'data_collector' =>
                array (
                    0 =>
                    array (
                        'template'  => 'ZenstruckVersionBundle:Version:toolbar2.0',
                        'id'        => 'version',
                    ),
                ),
            );

            $container->getDefinition('zenstruck.version.data_collector')->clearTag('data_collector');
            $container->getDefinition('zenstruck.version.data_collector')->setTags($tagForOldSymfony);
        }

        if ($config['version'])
            $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(1, $config['version']);
        else
        {
            if ($config['file'])
                $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(0, $config['file']);

            if ($config['suffix'])
                $container->getDefinition('zenstruck.version.data_collector')
                    ->replaceArgument(1, $config['suffix']);
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
