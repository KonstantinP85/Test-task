<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestController extends WebTestCase
{
    public function requestForResponse($method, $uri)
    {
        $client = static::createClient();
        $client->request($method, $uri);
        return $client;
    }


}