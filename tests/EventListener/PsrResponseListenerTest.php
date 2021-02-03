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

namespace Ajgarlag\Bundle\PsrHttpMessageBundle\Tests\EventListener;

use Ajgarlag\Bundle\PsrHttpMessageBundle\EventListener\PsrResponseListener;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Tests\Fixtures\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PsrResponseListenerTest extends \PHPUnit\Framework\TestCase
{
    public function testConvertsControllerResult()
    {
        $listener = new PsrResponseListener(new HttpFoundationFactory());
        $event = $this->createEventMock(new Response());
        $listener->onKernelView($event);
        $this->assertTrue($event->hasResponse());
    }

    public function testDoesNotConvertControllerResult()
    {
        $listener = new PsrResponseListener(new HttpFoundationFactory());
        $event = $this->createEventMock([]);

        $listener->onKernelView($event);
        $this->assertFalse($event->hasResponse());

        $event = $this->createEventMock(null);

        $listener->onKernelView($event);
        $this->assertFalse($event->hasResponse());
    }

    private function createEventMock($controllerResult)
    {
        return new ViewEvent($this->createMock(HttpKernelInterface::class), new Request(), HttpKernelInterface::MASTER_REQUEST, $controllerResult);
    }
}
