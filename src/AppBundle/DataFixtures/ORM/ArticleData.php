<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleData extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
            $Article = new Article();
            $Article->setName('Andy');
            $Article->setDescription('qwerty');
            $Article->setCreatedAt(new \DateTime());
            $manager->persist($Article);
            $manager->flush();


        }
}