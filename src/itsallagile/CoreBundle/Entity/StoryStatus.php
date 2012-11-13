<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="storyStatus") 
 */
class StoryStatus
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $statusId;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Story", mappedBy="status")
     */
    protected $stories;
    
    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }
        
    /**
     * Get statusId
     *
     * @return integer 
     */
    public function getStatusId()
    {
        return $this->statusId;
    }   

    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return text 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add stories
     *
     * @param itsallagile\CoreBundle\Entity\Story $stories
     */
    public function addStory(\itsallagile\CoreBundle\Entity\Story $stories)
    {
        $this->stories[] = $stories;
    }

    /**
     * Get stories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStories()
    {
        return $this->stories;
    }

    public function getArray()
    {
        $data = array(
            'id' => $this->statusId,
            'name' => $this->name,
        );
        
        return $data;
    }

    /**
     * Remove stories
     *
     * @param itsallagile\CoreBundle\Entity\Story $stories
     */
    public function removeStory(\itsallagile\CoreBundle\Entity\Story $stories)
    {
        $this->stories->removeElement($stories);
    }
}
