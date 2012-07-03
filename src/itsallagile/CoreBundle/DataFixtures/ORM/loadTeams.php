<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\Team;

class LoadTeams extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        
        $team = new Team();
        $team->setName('A-Team');
        $team->setVelocity(20);
        $user = $manager->merge($this->getReference('init-user'));
        $team->setOwner($user->getUserId());
        $manager->persist($team);
        $manager->flush();
        $user->addTeam($team);
        $manager->persist($user);
        $manager->flush();
        
        $this->addReference('init-team', $team);
    }

    public function getOrder()
    {
        return 3;
    }
}
