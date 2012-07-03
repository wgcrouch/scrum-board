<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\Board;

class LoadBoards extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        
        $board = new Board();
        $board->setName('Example Board');
        $board->setSlug('example');
        
        $manager->persist($board);
        $manager->flush();
        
        $this->addReference('init-board', $board);
    }

    public function getOrder()
    {
        return 4;
    }
}
