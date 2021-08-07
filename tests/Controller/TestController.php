<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestController extends WebTestCase
{
    /**
     * @param $method
     * @param $uri
     * @return KernelBrowser
     */
    public function requestForResponse($method, $uri): KernelBrowser
    {
        $client = static::createClient();
        $client->request($method, $uri);

        return $client;
    }


}