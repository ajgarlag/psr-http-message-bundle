<?php

/*
 * PsrHttpMessageBundle by @ajgarlag
 *
 * Copyright (c) 2010-2021 Fabien Potencier
 * Copyright (c) 2021 Antonio J. García Lagar
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AjgarlagPsrHttpMessageExtension extends Extension implements CompilerPassInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('psr7.xml');

        if ($config['alias_sensio_framework_extra_services']['enabled']) {
            $loader->load('alias_sensio_framework_extra.xml');
        }
    }

    public function process(ContainerBuilder $container)
    {
        $requiredInterfaces = [
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
        ];

        $nyholmPsr17Id = 'nyholm.psr7.psr17_factory';

        if (class_exists(Psr17Factory::class) && !$container->has($nyholmPsr17Id)) {
            $container->register($nyholmPsr17Id, Psr17Factory::class);
        }

        if ($container->has($nyholmPsr17Id)) {
            foreach ($requiredInterfaces as $requiredInterface) {
                if (!$container->has($requiredInterface)) {
                    $container->setAlias($requiredInterface, $nyholmPsr17Id);
                }
            }
        }
    }
}
