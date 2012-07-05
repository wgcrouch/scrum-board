<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

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
    protected $sort;
    
    /**
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="stories")
     * @ORM\JoinColumn(name="boardId", referencedColumnName="boardId")
     */
    protected $board;
    
    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="story")
     */
    protected $tickets;
    
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }
    

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
     * Set sort
     *
     * @param integer $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }
    
    public function getArray()
    {
        $data = array(
            'id' => $this->storyId,
            'sort' => $this->sort,
            'content' => $this->content,
            'boardId' => $this->board->getBoardId()
        );
        
        foreach ($this->getTickets() as $ticket) {
            $data['tickets'][] = $ticket->getArray(); 
        }
        
        return $data;
    }

    /**
     * Set board
     *
     * @param itsallagile\CoreBundle\Entity\Board $board
     */
    public function setBoard(\itsallagile\CoreBundle\Entity\Board $board)
    {
        $this->board = $board;
    }

    /**
     * Get board
     *
     * @return itsallagile\CoreBundle\Entity\Board 
     */
    public function getBoard()
    {
        return $this->board;
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
}