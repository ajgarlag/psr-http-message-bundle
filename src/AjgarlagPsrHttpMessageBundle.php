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

namespace Ajgarlag\Bundle\PsrHttpMessageBundle;

use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\AssertDefinedPsr17Factories;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\RegisterHttpMessageFactoriesPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\RegisterNyholmPsr17FactoriesPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\TagArgumentValueResolverPass;
use Ajgarlag\Bundle\PsrHttpMessageBundle\DependencyInjection\Compiler\TagViewEventListenerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AjgarlagPsrHttpMessageBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TagArgumentValueResolverPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1);
        $container->addCompilerPass(new RegisterHttpMessageFactoriesPass());
        $container->addCompilerPass(new RegisterNyholmPsr17FactoriesPass());
        $container->addCompilerPass(new AssertDefinedPsr17Factories());
        $container->addCompilerPass(new TagViewEventListenerPass());
    }
}
