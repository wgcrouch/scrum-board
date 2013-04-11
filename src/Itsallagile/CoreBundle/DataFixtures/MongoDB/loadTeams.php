<?php
namespace Itsallagile\ScrumboardBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Itsallagile\CoreBundle\Document\Team;

class LoadTeams extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $team = new Team();
        $team->setName('A-Team');
        $team->setVelocity(20);
        $admin = $manager->merge($this->getReference('admin-user'));
        $team->setOwner($admin);
        $team->addUser($admin);
        $manager->persist($team);
        $this->addReference('init-team', $team);

        $team2 = new Team();
        $team2->setName('PRime');
        $team2->setVelocity(25);
        $team2->setOwner($admin);
        $team2->addUser($admin);
        $manager->persist($team2);
        $this->addReference('team2', $team2);

        $manager->persist($admin);

        $user = $manager->merge($this->getReference('normal-user'));
        $team->addUser($user);
        $manager->persist($user);
        $manager->flush();


    }

    public function getOrder()
    {
        return 4;
    }
}
