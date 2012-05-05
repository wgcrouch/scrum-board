<?php

namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use itsallagile\CoreBundle\Entity\Ticket;

class LoadTicketData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        $ticket = new Ticket();
        $ticket->setColour('colour');
        $ticket->setContent('Ticket 1 from fixture');
        $ticket->setCssHash('aabbcc');


        $manager->persist($ticket);
        $manager->flush();
    }
}
