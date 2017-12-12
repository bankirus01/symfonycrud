<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Entities list', $crawler->filter('#container h1')->text());
    }


    public function testCreateAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/new');
        $Nametest = $crawler->filter('div#article > div > label')->text();
        $this->assertContains('Name', $Nametest); //ok
        $descriptionTest = $crawler->filter('div#article > div > label')
            ->eq(1)
            ->text();
        $this->assertContains('Description', $descriptionTest);
        $createdAtTest = $crawler->filter('div#article > div > label')
            ->eq(2)
            ->text();
        $this->assertContains('Created at', $createdAtTest);
        $form = $crawler->selectButton('Submit')->form();
        $form['article[name]'] = 'Andy';
        $form['article[description]'] = 'Test';
        $client->submit($form);
        $crawler = $client->request('GET', '/article');
        $this->assertContains('Andy', $crawler->filter('body > ul > li')->text());
        $this->assertContains('Test', $crawler->filter('body > ul > li')->text());
    }

    public function testUpdateAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');
        $link = $crawler->filter('a:contains("edit")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $form = $crawler->selectButton('Submit')->form();
        $form['article[name]'] = 'AndyP';
        $form['article[description]'] = 'Chtest';
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect('/article'));
    }
    public function testDeleteAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');
        $link = $crawler->filter('a:contains("delete")')
            ->eq(0)
            ->link();
        $crawler = $client->click($link);
        $this->assertTrue($client->getResponse()->isRedirect('/article'));
    }
}
