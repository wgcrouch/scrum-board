<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\Status;

class LoadStatuses extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        $statuses = array('New', 'Assigned', 'Done');
        foreach ($statuses as $status) {
            $statusObj = new Status();
            $statusObj->setName($status);
            
            $manager->persist($statusObj);
            $this->addReference('status-' . $status, $statusObj);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
