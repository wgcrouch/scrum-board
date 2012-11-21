<?php

namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\Common\Collections\ArrayCollection;
use itsallagile\CoreBundle\Document\ChatMessage;
use itsallagile\CoreBundle\Document\Story;
use itsallagile\CoreBundle\Document\Team;

/**
 * @MongoDB\Document(collection="boards", repositoryClass="itsallagile\CoreBundle\Repository\BoardRepository")
 * @MongoDBUnique(fields="slug")
 */
class Board
{
    /**
     * @MongoDB\Id
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
     * @param Team $team
     * @return Board
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * Get team
     *
     * @return Team $team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add story
     *
     * @param Story $story
     */
    public function addStory(Story $story)
    {
        $this->stories[] = $story;
    }

    /**
     * Get stories
     *
     * @return ArrayCollection $stories
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * Add chatMessage
     *
     * @param ChatMessage $chatMessage
     */
    public function addChatMessage(ChatMessage $chatMessage)
    {
        $this->chatMessages[] = $chatMessage;
    }

    /**
     * Get chatMessages
     *
     * @return ArrayCollection $chatMessages
     */
    public function getChatMessages()
    {
        return $this->chatMessages;
    }
    
    /**
     * Get a specific story
     * 
     * @param type $id
     * @return Story
     */
    public function getStory($id) 
    {
        foreach ($this->stories as $story) {
            if ($id == $story->getId()) {
                return $story;
            }
        }
        return false;
    }
    
    /**
     * Get a specfic chat message
     * 
     * @param type $id
     * @return ChatMessage
     */
    public function getChatMessage($id) 
    {
        foreach ($this->chatMessages as $message) {
            if ($id == $message->getId()) {
                return $message;
            }
        }
        return null;
    }
}
