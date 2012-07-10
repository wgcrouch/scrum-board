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
        $story->setSort(0);  
        $story->setPoints(5);
        $manager->persist($story);
        
        $story2 = new Story();
        $story2->setBoard($manager->merge($this->getReference('init-board')));
        $story2->setContent('Second Story');
        $story2->setSort(1);    
        $story2->setPoints(3);
        $manager->persist($story2);
                
        $manager->flush();
        
        $this->addReference('story1', $story);
        $this->addReference('story2', $story2);
    }

    public function getOrder()
    {
        return 5;
    }
}
