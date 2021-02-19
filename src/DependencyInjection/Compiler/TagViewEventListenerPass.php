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

use Ajgarlag\Bundle\PsrHttpMessageBundle\EventListener\PsrResponseListener;
use Symfony\Bridge\PsrHttpMessage\EventListener\PsrResponseListener as BridgePsrResponseListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TagViewEventListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (class_exists(BridgePsrResponseListener::class) && $container->hasDefinition(BridgePsrResponseListener::class) && $container->getDefinition(BridgePsrResponseListener::class)->hasTag('kernel.event_subscriber')) {
            return;
        }

        if ($container->hasDefinition(PsrResponseListener::class)) {
            $container
                ->getDefinition(PsrResponseListener::class)
                ->addTag('kernel.event_subscriber', ['priority' => -1])
            ;
        }
    }
}
