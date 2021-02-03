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

namespace Tests\Fixtures\ActionArgumentsBundle\Controller;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/action-arguments")
 */
class ActionArgumentsController
{
    /**
     * @Route("/invoke/")
     */
    public function __invoke(RequestInterface $request, MessageInterface $message, ServerRequestInterface $serverRequest)
    {
        return new Response('<html><body>ok</body></html>');
    }

    /**
     * @Route("/normal/")
     */
    public function normalAction(RequestInterface $request, MessageInterface $message, ServerRequestInterface $serverRequest)
    {
        return new Response('<html><body>ok</body></html>');
    }
}
