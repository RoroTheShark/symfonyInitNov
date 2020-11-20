<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 
        "Test de l'affichage de la liste des Articles");
    }
}
