<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\Ticket;

class LoadTickets extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        
        $ticket = new Ticket();
        $ticket->setStory($manager->merge($this->getReference('init-story')));
        $ticket->setStatus($manager->merge($this->getReference('status-New')));
        $ticket->setContent('Example Ticket');
        $ticket->setType('task');
        
        $manager->persist($ticket);
        $manager->flush();

    }

    public function getOrder()
    {
        return 6;
    }
}
