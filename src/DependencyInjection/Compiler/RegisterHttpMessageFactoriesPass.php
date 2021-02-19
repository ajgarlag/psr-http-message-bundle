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

namespace Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterHttpMessageFactoriesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->processHttpMessageFactory($container);
        $this->processHttpFoundationFactory($container);
    }

    private function processHttpMessageFactory(ContainerBuilder $container): void
    {
        if ($container->has(HttpMessageFactoryInterface::class)) {
            return;
        }

        if ($container->has(PsrHttpFactory::class)) {
            $container->setAlias(HttpMessageFactoryInterface::class, PsrHttpFactory::class);

            return;
        }

        $container
            ->register(HttpMessageFactoryInterface::class, PsrHttpFactory::class)
            ->setArguments([
                new Reference(ServerRequestFactoryInterface::class),
                new Reference(StreamFactoryInterface::class),
                new Reference(UploadedFileFactoryInterface::class),
                new Reference(ResponseFactoryInterface::class),
            ])
        ;
    }

    private function processHttpFoundationFactory(ContainerBuilder $container): void
    {
        if ($container->has(HttpFoundationFactoryInterface::class)) {
            return;
        }

        if ($container->has(HttpFoundationFactory::class)) {
            $container->setAlias(HttpFoundationFactoryInterface::class, HttpFoundationFactory::class);

            return;
        }

        $container
                ->register(HttpFoundationFactoryInterface::class, HttpFoundationFactory::class)
            ;
    }
}
