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

use Ajgarlag\Bundle\PsrHttpMessageBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Symfony\Bridge\PsrHttpMessage\ArgumentValueResolver\PsrServerRequestResolver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TagArgumentValueResolverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (class_exists(PsrServerRequestResolver::class) && $container->hasDefinition(PsrServerRequestResolver::class) && $container->getDefinition(PsrServerRequestResolver::class)->hasTag('controller.argument_value_resolver')) {
            return;
        }

        if ($container->hasDefinition(Psr7ServerRequestResolver::class)) {
            $container
                ->getDefinition(Psr7ServerRequestResolver::class)
                ->addTag('controller.argument_value_resolver', ['priority' => -1])
            ;
        }
    }
}
