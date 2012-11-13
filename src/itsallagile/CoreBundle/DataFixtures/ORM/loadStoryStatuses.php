<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\StoryStatus;

class LoadStoryStatuses extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $statuses = array('New', 'In Progress', 'Testable', 'Done');
        foreach ($statuses as $status) {
            $statusObj = new StoryStatus();
            $statusObj->setName($status);

            $manager->persist($statusObj);
            $this->addReference('story-status-' . $status, $statusObj);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
