<?php

/*
 * PsrHttpMessageBundle by @ajgarlag
 *
 * Copyright (c) 2010-2022 Fabien Potencier
 * Copyright (c) 2022 Antonio J. García Lagar
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ajgarlag\Bundle\PsrHttpMessageBundle\EventListener;

use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Converts PSR-7 Response to HttpFoundation Response using the bridge.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class PsrResponseListener implements EventSubscriberInterface
{
    /**
     * @var HttpFoundationFactoryInterface
     */
    private $httpFoundationFactory;

    public function __construct(HttpFoundationFactoryInterface $httpFoundationFactory)
    {
        $this->httpFoundationFactory = $httpFoundationFactory;
    }

    /**
     * Do the conversion if applicable and update the response of the event.
     */
    public function onKernelView(KernelEvent $event)
    {
        $controllerResult = $event->getControllerResult();

        if (!$controllerResult instanceof ResponseInterface) {
            return;
        }

        $event->setResponse($this->httpFoundationFactory->createResponse($controllerResult));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
        ];
    }
}
