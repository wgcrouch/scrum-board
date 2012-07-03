<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\User;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        
        $user = new User();
        $user->setFullName('Initial User');
        $user->setEmail('init@example.com');
        $user->setPassword('zhLPQlgtaCavojVYaftfVLlHfSg+jO/KDhTrQiO3j89pz+1PvO9jcgGAEZAUsySWq27My/ILFFKFhpUm3Wtjxg==');
        $user->setSalt('bf75305d07a38087ddaf8195b2ac000e');
        
        $manager->persist($user);
        $manager->flush();
        
        $this->addReference('init-user', $user);
    }

    public function getOrder()
    {
        return 2;
    }
}
