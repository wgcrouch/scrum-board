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
        $ticket->setStory($manager->merge($this->getReference('story1')));
        $ticket->setStatus($manager->merge($this->getReference('status-New')));
        $ticket->setContent('New Ticket');
        $ticket->setType('task');        
        $manager->persist($ticket);
        
        $ticket2 = new Ticket();
        $ticket2->setStory($manager->merge($this->getReference('story1')));
        $ticket2->setStatus($manager->merge($this->getReference('status-Assigned')));
        $ticket2->setContent('Assigned Ticket');
        $ticket2->setType('defect');        
        $manager->persist($ticket2);
        
        $ticket3 = new Ticket();
        $ticket3->setStory($manager->merge($this->getReference('story2')));
        $ticket3->setStatus($manager->merge($this->getReference('status-Done')));
        $ticket3->setContent('Don Ticket');
        $ticket3->setType('bug');        
        $manager->persist($ticket3);
        
        $ticket4 = new Ticket();
        $ticket4->setStory($manager->merge($this->getReference('story2')));
        $ticket4->setStatus($manager->merge($this->getReference('status-New')));
        $ticket4->setContent('New Ticket in new story');
        $ticket4->setType('bug');        
        $manager->persist($ticket4);
        
        $manager->flush();

    }

    public function getOrder()
    {
        return 6;
    }
}
