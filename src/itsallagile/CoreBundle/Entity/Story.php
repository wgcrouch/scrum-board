<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="story") 
 */
class Story {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $storyId;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $x = 1;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $y = 1;
    

    /**
     * Get storyId
     *
     * @return integer 
     */
    public function getStoryId()
    {
        return $this->storyId;
    }

    

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set x
     *
     * @param integer $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Get x
     *
     * @return integer 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    /**
     * Get y
     *
     * @return integer 
     */
    public function getY()
    {
        return $this->y;
    }

    
    
    public function getArray()
    {
        $data = array(
            'id' => $this->storyId,
            'x' => $this->x,
            'y' => $this->y,
            'content' => $this->content,
        );
        return $data;
    }
}