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

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Tests\Fixtures\ActionArgumentsBundle\Controller\ActionArgumentsController;

return function (RoutingConfigurator $routes) {
    $routes->add('action_arguments_bundle_invoke', '/action-arguments/invoke/')
        ->controller(ActionArgumentsController::class)
    ;

    $routes->add('action_arguments_bundle_normal', '/action-arguments/normal/')
        ->controller(ActionArgumentsController::class, 'normalAction')
    ;
};
