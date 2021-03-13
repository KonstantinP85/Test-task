<?php


namespace App\Tests\Controller;



use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthorControllerTest extends WebTestCase
{
    public function testShowAuthors()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertPageTitleContains('Authors');
        $this->assertSelectorTextContains('h4', 'Добавить автора');
    }

}