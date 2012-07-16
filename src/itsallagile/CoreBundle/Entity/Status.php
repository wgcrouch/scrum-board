<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="status") 
 */
class Status {
    
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
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="status")
     */
    protected $tickets;
    
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
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
     * Add tickets
     *
     * @param itsallagile\CoreBundle\Entity\Ticket $tickets
     */
    public function addTicket(\itsallagile\CoreBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;
    }

    /**
     * Get tickets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    public function getArray()
    {
        $data = array(
            'id' => $this->statusId,
            'name' => $this->name,
        );
        
        return $data;
    }
}