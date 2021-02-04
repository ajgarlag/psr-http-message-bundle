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

use Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentValueResolver\Psr7ServerRequestResolver;
use Tests\Fixtures\ActionArgumentsBundle\Controller\ActionArgumentsController;

return static function (ContainerConfigurator $container) {
    $container->extension('framework', [
        'test' => true,
        'secret' => 'test',
        'router' => [
            'resource' => '%kernel.project_dir%/config/routing.php',
        ],
    ]);

    $container->extension('monolog', [
        'handlers' => [
            'main' => [
                'type' => 'stream',
                'path' => '%kernel.logs_dir%/console.log',
                'level' => 'critical',
                'channels' => [],
            ],
        ],
    ]);

    if (class_exists(Psr7ServerRequestResolver::class)) {
        $container->extension('sensio_framework_extra', [
            'psr_message' => ['enabled' => true],
        ]);
    }

    $container->services()->set(ActionArgumentsController::class)->public();
};
