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

use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

require_once 'legacy-lt5.1.php';

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->alias('sensio_framework_extra.psr7.http_message_factory', 'ajgarlag_psr_http_message.psr7.http_message_factory')
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.1', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', HttpMessageFactoryInterface::class)))
    ;

    $services->alias('sensio_framework_extra.psr7.http_foundation_factory', 'ajgarlag_psr_http_message.psr7.http_foundation_factory')
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.1', sprintf('The "%%alias_id%%" service alias is deprecated. Use "%s" instead.', HttpFoundationFactoryInterface::class)))
    ;

    $services->alias('sensio_framework_extra.psr7.argument_value_resolver.server_request', 'ajgarlag_psr_http_message.psr7.argument_value_resolver.server_request')
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.1', 'The "%%alias_id%%" service alias is deprecated.'))
    ;

    $services->alias('sensio_framework_extra.psr7.listener.response', 'ajgarlag_psr_http_message.psr7.listener.response')
        ->deprecate(...deprecate_build_arguments('ajgarlag/psr-http-message-bundle', '1.1', 'The "%%alias_id%%" service alias is deprecated.'))
    ;
};
