<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BookControllerTest extends WebTestCase
{
    public function testShowAuthors()
    {
        $client = static::createClient();
        $client->request('GET', '/author/'.rand(1,5).'/books');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertPageTitleContains('Books');
        $this->assertSelectorTextContains('h4', 'Добавить книгу');
        $this->assertSelectorTextContains('h3', 'Страница автора');
    }
}