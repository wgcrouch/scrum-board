<?php
namespace itsallagile\ScrumboardBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use itsallagile\CoreBundle\Entity\Story;
use itsallagile\CoreBundle\Entity\StoryStatus;

class LoadStories extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $newStatus = $manager->merge($this->getReference('story-status-New'));
               
        $story = new Story();
        $story->setBoard($manager->merge($this->getReference('init-board')));
        $story->setContent('Example Story');
        $story->setSort(0);
        $story->setPoints(5);  
        $story->setStatus($newStatus);
        $manager->persist($story);

        $story2 = new Story();
        $story2->setBoard($manager->merge($this->getReference('init-board')));
        $story2->setContent('Second Story');
        $story2->setSort(1);
        $story2->setPoints(3);
        $story2->setStatus($newStatus);
        $manager->persist($story2);

        $manager->flush();

        $this->addReference('story1', $story);
        $this->addReference('story2', $story2);
    }

    public function getOrder()
    {
        return 6;
    }
}
