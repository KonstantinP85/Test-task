<?php


namespace App\Tests\Controller;



use Symfony\Component\HttpFoundation\Response;

class BookControllerTest extends TestController
{

    public function testShowBook()
    {
        $this->requestForResponse('GET', '/author/'.rand(1,10).'/books');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertPageTitleContains('Books');
        $this->assertSelectorTextContains('h4', 'Добавить книгу');
        $this->assertSelectorTextContains('h3', 'Страница автора');
    }

    public function testCreateBook()
    {
        $client=$this->requestForResponse('GET', '/author/2/book/create');
        $client->submitForm('Сохранить', $this->exampleBookCreate());
        $client->getResponse()->getContent();

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('td:contains("Аленький цветочек")');
        $this->assertSelectorExists('td:contains("1850")');
    }

    public function testUpdateBook()
    {
        $client=$this->requestForResponse('GET', '/author/2/book/update/12');
        $client->submitForm('Сохранить', $this->exampleBookUpdate());
        $client->getResponse()->getContent();

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('td:contains("Мертвые души")');
        $this->assertSelectorExists('td:contains("1810")');
    }

    public function exampleBookCreate()
    {
        return ['book[title]' => 'Аленький цветочек', 'book[year]' => '1850'];
    }

    public function exampleBookUpdate()
    {
        return ['book[title]' => 'Мертвые души', 'book[year]' => '1810'];
    }
}