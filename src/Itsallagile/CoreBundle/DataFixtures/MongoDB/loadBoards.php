<?php
namespace Itsallagile\ScrumboardBundle\DataFixtures\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Itsallagile\CoreBundle\Document\Board;
use Itsallagile\CoreBundle\Document\Story;
use Itsallagile\CoreBundle\Document\Ticket;

class LoadBoards extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $board = new Board();
        $board->setName('Example Board');
        $board->setSlug('example');
        $board->setTeam($manager->merge($this->getReference('init-team')));

        $story = new Story();
        $story->setContent('Example Story');
        $story->setSort(0);
        $story->setPoints(5);
        $story->setStatus(Story::STATUS_NEW);
        $board->addStory($story);

        $ticket = new Ticket();
        $ticket->setStatus(Ticket::STATUS_NEW);
        $ticket->setContent('New Ticket');
        $ticket->setType('task');
        $story->addTicket($ticket);

        $ticket2 = new Ticket();
        $ticket2->setStatus(Ticket::STATUS_ASSIGNED);
        $ticket2->setContent('Assigned Ticket');
        $ticket2->setType('defect');
        $story->addTicket($ticket2);

        $story2 = new Story();
        $story2->setContent('Second Story');
        $story2->setSort(1);
        $story2->setPoints(3);
        $story2->setStatus(Story::STATUS_NEW);
        $board->addStory($story2);

        $ticket3 = new Ticket();
        $ticket3->setStatus(Ticket::STATUS_DONE);
        $ticket3->setContent('Done Ticket');
        $ticket3->setType('bug');
        $story2->addTicket($ticket3);

        $ticket4 = new Ticket();
        $ticket4->setStatus(Ticket::STATUS_NEW);
        $ticket4->setContent('New Ticket in new story');
        $ticket4->setType('bug');
        $story2->addTicket($ticket4);

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
