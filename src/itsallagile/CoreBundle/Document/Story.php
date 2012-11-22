<?php
namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SerializerBundle\Annotation as JMS;

/** 
 * @MongoDB\EmbeddedDocument 
 */
class Story
{
    
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_TESTABLE = 'testable';
    const STATUS_DONE = 'done';
    
    /**
     * @JMS\Exclude
     */
    protected static $statuses = array(
        self::STATUS_NEW => 'New',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_TESTABLE => 'Testable',
        self::STATUS_DONE => 'Done'
    );
    
    /**
     * Get the possible statuses for a story
     * 
     * @return array
     */
    public static function getStatuses()
    {
        return self::$statuses;
    }
    
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $sort;

    /**
     * @MongoDB\EmbedMany(targetDocument="Ticket")
     */
    protected $tickets;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $points;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    /**
     * Get id
     *
     * @return custom_id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Story
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set sort
     *
     * @param int $sort
     * @return Story
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Get sort
     *
     * @return int $sort
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Add tickets
     *
     * @param itsallagile\CoreBundle\Document\Ticket $ticket
     */
    public function addTicket(\itsallagile\CoreBundle\Document\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    /**
     * Get tickets
     *
     * @return Doctrine\Common\Collections\Collection $tickets
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set points
     *
     * @param int $points
     * @return Story
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * Get points
     *
     * @return int $points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Story
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Get a specific ticket
     *
     * @param string $id
     * @return Ticket
     */
    public function getTicket($id) 
    {
        foreach ($this->tickets as $ticket) {
            if ($id == $ticket->getId()) {
                return $ticket;
            }
        }
        return null;
    }
    
    public function removeTicket(Ticket $ticket) 
    {
        return $this->tickets->removeElement($ticket);
    }
}
