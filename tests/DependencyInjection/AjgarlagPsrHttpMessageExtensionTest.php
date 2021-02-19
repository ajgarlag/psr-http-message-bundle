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

namespace Ajgarlag\Bundle\PsrHttpMessageBundle\Tests\DependencyInjection;

use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\AjgarlagPsrHttpMessageExtension;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\RegisterHttpMessageFactoriesPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\RegisterNyholmPsr17FactoriesPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\TagArgumentValueResolverPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AjgarlagPsrHttpMessageExtensionTest extends TestCase
{
    public function testDefaultConfiguration()
    {
        $container = new ContainerBuilder();
        $config = [];
        $this->compileExtension($container, $config);

        $this->assertTrue($container->has(HttpMessageFactoryInterface::class));
        $this->assertTrue($container->has(HttpFoundationFactoryInterface::class));

        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_foundation_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_message_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.listener.response'));

        $this->assertFalse($container->hasAlias('sensio_framework_extra.psr7.http_message_factory'));
        $this->assertFalse($container->hasAlias('sensio_framework_extra.psr7.http_foundation_factory'));
        $this->assertFalse($container->hasAlias('sensio_framework_extra.psr7.argument_value_resolver.server_request'));
        $this->assertFalse($container->hasAlias('sensio_framework_extra.psr7.listener.response'));
    }

    private function compileExtension(ContainerBuilder $container, array $config): void
    {
        $extension = new AjgarlagPsrHttpMessageExtension();
        $extension->load([$config], $container);
        $extension->process($container);
        (new TagArgumentValueResolverPass())->process($container);
        (new RegisterHttpMessageFactoriesPass())->process($container);
        (new RegisterNyholmPsr17FactoriesPass())->process($container);
    }

    public function testSensioFrameworkExtraAliasConfiguration()
    {
        $container = new ContainerBuilder();
        $config = [
            'alias_sensio_framework_extra_services' => [
                'enabled' => true,
            ],
        ];
        $this->compileExtension($container, $config);

        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_message_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_foundation_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.listener.response'));

        $this->assertAlias($container, 'sensio_framework_extra.psr7.http_message_factory', 'ajgarlag_psr_http_message.psr7.http_message_factory');
        $this->assertAlias($container, 'sensio_framework_extra.psr7.http_foundation_factory', 'ajgarlag_psr_http_message.psr7.http_foundation_factory');
        $this->assertAlias($container, 'sensio_framework_extra.psr7.argument_value_resolver.server_request', 'ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request');
        $this->assertAlias($container, 'sensio_framework_extra.psr7.listener.response', 'ajgarlag_psr_http_message.psr7.listener.response');
    }

    public function testAjgarlagPsrHttpMessageAliasConfiguration()
    {
        if (!class_exists(Psr7ServerRequestResolver::class)) {
            $this->markTestSkipped('Require sensio/framework-extra-bundle:>=5.3 <6');
        }

        $container = new ContainerBuilder();
        $config = [
            'alias_sensio_framework_extra_services' => [
                'enabled' => (bool) random_int(0, 1),
            ],
        ];
        $container->setParameter('ajgarlag_psr_http_message_sensio_psr7_enabled', true);
        $this->compileExtension($container, $config);

        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_message_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.http_foundation_factory'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request'));
        $this->assertTrue($container->has('ajgarlag_psr_http_message.psr7.listener.response'));

        $this->assertAlias($container, 'ajgarlag_psr_http_message.psr7.http_message_factory', 'sensio_framework_extra.psr7.http_message_factory');
        $this->assertAlias($container, 'ajgarlag_psr_http_message.psr7.http_foundation_factory', 'sensio_framework_extra.psr7.http_foundation_factory');
        $this->assertAlias($container, 'ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request', 'sensio_framework_extra.psr7.argument_value_resolver.server_request');
        $this->assertAlias($container, 'ajgarlag_psr_http_message.psr7.listener.response', 'sensio_framework_extra.psr7.listener.response');
    }

    private function assertAlias(ContainerBuilder $container, $key, $value): void
    {
        $this->assertEquals($value, (string) $container->getAlias($key));
    }
}
