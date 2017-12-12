<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testId()
    {
        $article = new Article();
        $this->assertEquals(null , $article->getId());
    }

    public function testName()
    {
        $nameTest = 'Testing';
        $testArticle = new Article();
        $testArticle->setName($nameTest);
        $this->assertEquals($nameTest, $testArticle->getName());
    }

    public function testDescription()
    {
        $DescriptionTest = 'Testing';
        $testArticle = new Article();
        $testArticle->setDescription($DescriptionTest);
        $this->assertEquals($DescriptionTest, $testArticle->getDescription());
    }

    public function testCreated()
    {
        $createdTest = new \DateTime('2017-01-01 00:00:00');
        $testArticle = new Article();
        $testArticle->setCreatedAt($createdTest);
        $this->assertEquals($createdTest, $testArticle->getCreatedAt());
    }
}