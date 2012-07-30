<?php

namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="chatMessage") 
 */
class ChatMessage {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $chatMessageId;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="Board", inversedBy="chatMessages")
     * @ORM\JoinColumn(name="boardId", referencedColumnName="boardId")
     */
    protected $board;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="userId")
     */
    protected $user;    
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $datetime;
    
    public function __construct()
    {
       
    }
    

    public function getArray()
    {
        $data = array(
            'id' => $this->chatMessageId,
            'content' => $this->content,
            'boardId' => $this->board->getBoardId(),
            'userId' => $this->user->getUserId()
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
     * Get chatMessageId
     *
     * @return integer 
     */
    public function getChatMessageId()
    {
        return $this->chatMessageId;
    }

    /**
     * Set content
     *
     * @param text $content
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
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datetime
     *
     * @param datetime $datetime
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
     * @return datetime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set user
     *
     * @param itsallagile\CoreBundle\Entity\User $user
     * @return ChatMessage
     */
    public function setUser(\itsallagile\CoreBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return itsallagile\CoreBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}