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
use Psr\Http\Message\UriFactoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\Configuration as SensioFrameworkExtraConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\AliasDeprecatedPublicServicesPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AjgarlagPsrHttpMessageExtension extends Extension implements CompilerPassInterface, PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        if (!class_exists(Psr7ServerRequestResolver::class)) {
            return;
        }

        if (isset($bundles['SensioFrameworkExtraBundle'])) {
            $configs = $container->getExtensionConfig('sensio_framework_extra');
            $config = $this->processConfiguration(new SensioFrameworkExtraConfiguration(), $configs);
            $sensioPsr7Enabled = isset($config['psr_message']['enabled']) && $config['psr_message']['enabled'];
            $container->setParameter('ajgarlag_psr_http_message_sensio_psr7_enabled', $sensioPsr7Enabled);
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($this->isSensioFrameworkExtraPsr7SupportEnabled($container)) {
            $loader->load('alias_ajgarlag_psr_http_message.xml');

            return;
        }

        $loader->load('psr7.xml');

        if ($config['alias_sensio_framework_extra_services']['enabled']) {
            if (!class_exists(AliasDeprecatedPublicServicesPass::class)) {
                $loader->load('alias_sensio_framework_extra_legacy.xml');
            } else {
                $loader->load('alias_sensio_framework_extra.xml');
            }
        }
    }

    private function isSensioFrameworkExtraPsr7SupportEnabled(ContainerBuilder $container): bool
    {
        if (!$container->hasParameter('ajgarlag_psr_http_message_sensio_psr7_enabled')) {
            return false;
        }

        return (bool) $container->getParameter('ajgarlag_psr_http_message_sensio_psr7_enabled');
    }

    public function process(ContainerBuilder $container)
    {
        $requiredInterfaces = [
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
            UriFactoryInterface::class,
        ];

        $nyholmPsr17Id = 'nyholm.psr7.psr17_factory';

        if (!$container->has($nyholmPsr17Id) && class_exists(Psr17Factory::class)) {
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
