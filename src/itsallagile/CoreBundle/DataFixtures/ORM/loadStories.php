<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use itsallagile\CoreBundle\Entity\Story;

class LoadStories extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {        
        
        $story = new Story();
        $story->setBoard($manager->merge($this->getReference('init-board')));
        $story->setContent('Example Story');
        $story->setOrder(0);
        
        $manager->persist($story);
        $manager->flush();
        
        $this->addReference('init-story', $story);
    }

    public function getOrder()
    {
        return 5;
    }
}
