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

use Sensio\Bundle\FrameworkExtraBundle\DependencyInjection\Configuration as SensioFrameworkExtraConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
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

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($this->isSensioFrameworkExtraPsr7SupportEnabled($container)) {
            $loader->load('alias_ajgarlag_psr_http_message.php');

            return;
        }

        $loader->load('psr7.php');

        if ($config['alias_sensio_framework_extra_services']['enabled']) {
            $loader->load('alias_sensio_framework_extra.php');
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
    }
}
