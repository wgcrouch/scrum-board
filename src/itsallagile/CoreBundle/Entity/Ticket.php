<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ticket")
 */
class Ticket
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $ticketId;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=45)
     */
    protected $type;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parent;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Story", inversedBy="tickets")
     * @ORM\JoinColumn(name="storyId", referencedColumnName="storyId")
     */
    protected $story;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="tickets")
     * @ORM\JoinColumn(name="statusId", referencedColumnName="statusId")
     */
    protected $status;

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
            'content' => $this->content,
            'parent' => $this->parent,
            'status' => $this->getStatus()->getStatusId(),
            'story' => $this->getStory()->getStoryId(),

        );
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
     * Set story
     *
     * @param itsallagile\CoreBundle\Entity\Story $story
     */
    public function setStory(\itsallagile\CoreBundle\Entity\Story $story)
    {
        $this->story = $story;
    }

    /**
     * Get story
     *
     * @return itsallagile\CoreBundle\Entity\Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set status
     *
     * @param itsallagile\CoreBundle\Entity\Status $status
     */
    public function setStatus(\itsallagile\CoreBundle\Entity\Status $status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return itsallagile\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }
}
