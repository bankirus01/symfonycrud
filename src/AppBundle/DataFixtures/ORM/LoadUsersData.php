<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsersData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userFirst = new Users();
        $userFirst->setUsername('trash');
        $userFirst->setPassword(password_hash('0000', PASSWORD_BCRYPT));

        $manager->persist($userFirst);
        $manager->flush();

        $this->addReference('trash-user',$userFirst);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getOrder()
    {
        return 1;
    }
}