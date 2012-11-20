<?php

namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="boards", repositoryClass="itsallagile\CoreBundle\Repository\BoardRepository")
 * @MongoDBUnique(fields="slug")
 */
class Board
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $slug;

    /** 
     * @MongoDB\EmbedMany(targetDocument="Story") 
     */
    protected $stories;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Team")
     * @Assert\NotBlank()
     */
    protected $team;
    
    /**
     * @MongoDB\EmbedMany(targetDocument="ChatMessage")
     */
    protected $chatMessages;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
        $this->chatMessages = new ArrayCollection();
    }

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Set slug
     *
     * @param text $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return text
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set team
     *
     * @param itsallagile\CoreBundle\Document\Team $team
     * @return Board
     */
    public function setTeam(\itsallagile\CoreBundle\Document\Team $team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * Get team
     *
     * @return itsallagile\CoreBundle\Document\Team $team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add story
     *
     * @param itsallagile\CoreBundle\Document\Story $story
     */
    public function addStory(\itsallagile\CoreBundle\Document\Story $story)
    {
        $this->stories[] = $story;
    }

    /**
     * Get stories
     *
     * @return Doctrine\Common\Collections\Collection $stories
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * Add chatMessage
     *
     * @param itsallagile\CoreBundle\Document\ChatMessage $chatMessage
     */
    public function addChatMessage(\itsallagile\CoreBundle\Document\ChatMessage $chatMessage)
    {
        $this->chatMessages[] = $chatMessage;
    }

    /**
     * Get chatMessages
     *
     * @return Doctrine\Common\Collections\Collection $chatMessages
     */
    public function getChatMessages()
    {
        return $this->chatMessages;
    }
}
