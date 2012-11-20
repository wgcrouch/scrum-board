<?php

namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * @MongoDB\EmbeddedDocument 
 */
class ChatMessage
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $user;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $datetime;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ChatMessage
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
     * Set user
     *
     * @param string $user
     * @return ChatMessage
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set datetime
     *
     * @param date $datetime
     * @return ChatMessage
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * Get datetime
     *
     * @return date $datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}
