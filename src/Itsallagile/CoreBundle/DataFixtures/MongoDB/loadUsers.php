<?php
namespace Itsallagile\ScrumboardBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Itsallagile\CoreBundle\Document\User;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setFullName('Admin User');
        $adminUser->setEmail('admin@example.com');
        $adminUser->setEnabled('true');
        $adminUser->setPlainPassword(
            'password'
        );
        $adminUser->setSuperAdmin(true);

        $manager->persist($adminUser);
        $manager->flush();

        $this->addReference('admin-user', $adminUser);

        $user = new User();
        $user->setUsername('user');
        $user->setFullName('Normal User');
        $user->setEmail('init@example.com');
        $user->setEnabled('true');
        $user->setPlainPassword(
            'password'
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference('normal-user', $user);
    }

    public function getOrder()
    {
        return 3;
    }
}
