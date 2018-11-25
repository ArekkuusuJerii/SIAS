<?php

namespace BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        /** @noinspection PhpUnusedLocalVariableInspection */
        $crawler = $client->request('GET', '/');

        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
