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

use LogicException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AssertDefinedPsr17Factories implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $requiredInterfaces = [
            ResponseFactoryInterface::class,
            ServerRequestFactoryInterface::class,
            StreamFactoryInterface::class,
            UploadedFileFactoryInterface::class,
        ];

        foreach ($requiredInterfaces as $requiredInterface) {
            if (!$container->has($requiredInterface)) {
                throw new LogicException(sprintf('Service for PSR-17 factory "%s" not found. Run "composer require nyholm/psr7" to install the recommended implementation.', $requiredInterface));
            }
        }
    }
}
