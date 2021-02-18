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

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterNyholmPsr17FactoriesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $requiredInterfaces = [
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
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
