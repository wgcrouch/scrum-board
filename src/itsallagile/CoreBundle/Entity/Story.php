<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="story")
 */
class Story
{
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
     * @ORM\Column(type="integer", nullable=true)
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

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $points;

    /**
     * @ORM\ManyToOne(targetEntity="StoryStatus", inversedBy="stories")
     * @ORM\JoinColumn(name="statusId", referencedColumnName="statusId")
     */
    protected $status;
    
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
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set points
     *
     * @param integer $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * Get Status
     *
     * @return itsallagile\CoreBundle\Entity\StoryStatus 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set status
     *
     * @param itsallagile\CoreBundle\Entity\StoryStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
            'points' => $this->points,
            'status' => $this->status->getStatusId(),
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

    /**
     * Remove tickets
     *
     * @param <variableType$tickets
     */
    public function removeTicket(\itsallagile\CoreBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    public function __toString()
    {
        return (string)$this->storyId;
    }
}
