<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class AuthorControllerTest extends TestController
{
    public function testShowAuthors()
    {
        $this->requestForResponse('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertPageTitleContains('Authors');
        $this->assertSelectorTextContains('h4', 'Добавить автора');
    }

    public function testCreateAuthor()
    {
        $client=$this->requestForResponse('GET', '/author/create');
        $client->submitForm('Сохранить', $this->exampleAuthorCreate());
        $client->getResponse()->getContent();

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('td:contains("Марина")');
        $this->assertSelectorExists('td:contains("Цветаева")');
    }

    public function testUpdateAuthor()
    {
        $client=$this->requestForResponse('GET', '/author/update/'.rand(1,10));
        $client->submitForm('Сохранить', $this->exampleAuthorUpdate());
        $client->getResponse()->getContent();
        
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('td:contains("Эрнест")');
        $this->assertSelectorExists('td:contains("Хэмингуэй")');
    }

    /**
     * @return string[]
     */
    public function exampleAuthorCreate(): array
    {
        return ['author[name]' => 'Марина', 'author[surname]' => 'Цветаева'];
    }

    /**
     * @return string[]
     */
    public function exampleAuthorUpdate(): array

    {
        return ['author[name]' => 'Эрнест', 'author[surname]' => 'Хэмингуэй'];
    }

}