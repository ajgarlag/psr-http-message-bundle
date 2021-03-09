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

use Symfony\Component\DependencyInjection\Compiler\AliasDeprecatedPublicServicesPass;

if (!class_exists(AliasDeprecatedPublicServicesPass::class)) {
    function service(string $serviceId): ReferenceConfigurator
    {
        return ref($serviceId);
    }
}

function deprecate_build_arguments(string $package, string $version, string $message): array
{
    if (!class_exists(AliasDeprecatedPublicServicesPass::class)) {
        $deprecationMessage = sprintf('Since %s %s', $package, $version);
        if ('' !== $message) {
            $deprecationMessage .= ': '.$message;
        }

        return [$deprecationMessage];
    }

    return [$package, $version, $message];
}
