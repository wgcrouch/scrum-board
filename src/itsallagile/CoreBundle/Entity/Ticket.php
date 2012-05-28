<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ticket") 
 */
class Ticket {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $ticketId;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $type;
    
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parent;

    /**
     * Get ticketId
     *
     * @return integer 
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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

    /**
     * Set parent
     *
     * @param integer $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function getArray()
    {
        $data = array(
            'id' => $this->ticketId,
            'type' => $this->type,
            'x' => $this->x,
            'y' => $this->y,
            'content' => $this->content,
            'parent' => $this->parent
        );
        return $data;
    }
}