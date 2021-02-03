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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Psr7RequestTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testController($url)
    {
        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertEquals('ok', $crawler->filterXPath('//body')->html());
    }

    public static function urlProvider()
    {
        return [
            ['/action-arguments/normal/'],
            ['/action-arguments/invoke/'],
        ];
    }
}
