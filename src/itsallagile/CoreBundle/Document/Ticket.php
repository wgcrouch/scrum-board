<?php

namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @MongoDB\EmbeddedDocument 
 */
class Ticket
{
    const STATUS_NEW = 'New';
    const STATUS_ASSIGNED = 'Assigned';
    const STATUS_DONE = 'Done';
    
    protected $statuses = array(
        self::STATUS_NEW,
        self::STATUS_ASSIGNED,
        self::STATUS_DONE
    );
    
    /**
     * Get the possible statuses for a ticket
     * @return array
     */
    public static function getStatuses()
    {
        return array_combine($this->statuses, $this->statuses);
    }
    
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $type;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $status;

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
     * Set type
     *
     * @param string $type
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Ticket
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
     * Set status
     *
     * @param string $status
     * @return Ticket
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
}
