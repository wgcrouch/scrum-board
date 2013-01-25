<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Document\User;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $adminUser = new User();
        $adminUser->setFullName('Admin User');
        $adminUser->setEmail('admin@example.com');
        $adminUser->setPassword(
            'zhLPQlgtaCavojVYaftfVLlHfSg+jO/KDhTrQiO3j89pz+1PvO9jcgGAEZAUsySWq27My/ILFFKFhpUm3Wtjxg=='
        );
        $adminUser->setSalt('bf75305d07a38087ddaf8195b2ac000e');

        $manager->persist($adminUser);
        $manager->flush();

        $this->addReference('admin-user', $adminUser);

        $user = new User();
        $user->setFullName('Normal User');
        $user->setEmail('init@example.com');
        $user->setPassword(
            'zhLPQlgtaCavojVYaftfVLlHfSg+jO/KDhTrQiO3j89pz+1PvO9jcgGAEZAUsySWq27My/ILFFKFhpUm3Wtjxg=='
        );
        $user->setSalt('bf75305d07a38087ddaf8195b2ac000e');

        $manager->persist($user);
        $manager->flush();

        $this->addReference('normal-user', $user);
    }

    public function getOrder()
    {
        return 3;
    }
}
