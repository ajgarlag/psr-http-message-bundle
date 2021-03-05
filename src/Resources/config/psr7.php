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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ajgarlag\Bundle\PsrHttpMessageBundle\EventListener\PsrResponseListener;
use Ajgarlag\Bundle\PsrHttpMessageBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

require_once 'legacy-lt5.1.php';

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->set(Psr7ServerRequestResolver::class)
        ->arg(0, service(HttpMessageFactoryInterface::class))
    ;

    $services->set(PsrResponseListener::class)
        ->arg(0, service(HttpFoundationFactoryInterface::class))
    ;

    $services->alias('ajgarlag_psr_http_message.psr7.http_message_factory', HttpMessageFactoryInterface::class)
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.2', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', HttpMessageFactoryInterface::class)))
    ;

    $services->alias('ajgarlag_psr_http_message.psr7.http_foundation_factory', HttpFoundationFactoryInterface::class)
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.2', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', HttpFoundationFactoryInterface::class)))
    ;

    $services->alias('ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request', Psr7ServerRequestResolver::class)
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.2', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', Psr7ServerRequestResolver::class)))
    ;

    $services->alias('ajgarlag_psr_http_message.psr7.listener.response', PsrResponseListener::class)
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.2', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', PsrResponseListener::class)))
    ;
};
