<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Document\Board;

class LoadBoards extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $board = new Board();
        $board->setName('Example Board');
        $board->setSlug('example');
        $board->setTeam($manager->merge($this->getReference('init-team')));
        $manager->persist($board);

        $this->addReference('init-board', $board);

        $board2 = new Board();
        $board2->setName('Another Board');
        $board2->setSlug('another');
        $board2->setTeam($manager->merge($this->getReference('team2')));
        $manager->persist($board2);
        $manager->flush();

        $this->addReference('board2', $board2);
    }

    public function getOrder()
    {
        return 5;
    }
}
