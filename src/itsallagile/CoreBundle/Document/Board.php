<?php

namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="boards", repositoryClass="itsallagile\CoreBundle\Repository\BoardRepository")
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

//    /**
//     * @ORM\OneToMany(targetEntity="Story", mappedBy="board")
//     */
//    protected $stories;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Team")
     * @Assert\NotBlank()
     */
    protected $team;

//    /**
//     * @ORM\OneToMany(targetEntity="ChatMessage", mappedBy="board")
//     */
//    protected $chatMessages;

    public function __construct()
    {
//        $this->stories = new ArrayCollection();
//        $this->chatMessages = new ArrayCollection();
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

//    public function getArray()
//    {
//        $data = array(
//            'id' => $this->boardId,
//            'name' => $this->name,
//            'slug' => $this->slug,
//            'team' => $this->team->getArray()
//        );
//
//        foreach ($this->getStories() as $story) {
//            $data['stories'][] = $story->getArray();
//        }
//
//        foreach ($this->getChatMessages() as $message) {
//            $data['chatMessages'][] = $message->getArray();
//        }
//        return $data;
//    }
//   
//     /**
//     * Add stories
//     *
//     * @param itsallagile\CoreBundle\Entity\Story $stories
//     */
//    public function addStory(\itsallagile\CoreBundle\Entity\Story $stories)
//    {
//        $this->stories[] = $stories;
//    }
//
//    /**
//     * Get stories
//     *
//     * @return Doctrine\Common\Collections\Collection
//     */
//    public function getStories()
//    {
//        return $this->stories;
//    }
//
//    /**
//     * Add chatMessages
//     *
//     * @param itsallagile\CoreBundle\Entity\ChatMessage $chatMessages
//     * @return Board
//     */
//    public function addChatMessage(\itsallagile\CoreBundle\Entity\ChatMessage $chatMessages)
//    {
//        $this->chatMessages[] = $chatMessages;
//        return $this;
//    }
//
//    /**
//     * Remove chatMessages
//     *
//     * @param <variableType$chatMessages
//     */
//    public function removeChatMessage(\itsallagile\CoreBundle\Entity\ChatMessage $chatMessages)
//    {
//        $this->chatMessages->removeElement($chatMessages);
//    }
//
//    /**
//     * Get chatMessages
//     *
//     * @return Doctrine\Common\Collections\Collection
//     */
//    public function getChatMessages()
//    {
//        return $this->chatMessages;
//    }


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
}
