<?php
namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="teams", repositoryClass="itsallagile\CoreBundle\Repository\TeamRepository")
 */
class Team
{
    /**
     * @MongoDB\Id(strategy="INCREMENT")
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User")
     */
    protected $owner;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $velocity;

    /**
     * @MongoDB\ReferenceMany(targetDocument="User")
     */
    protected $users = array();

//    /**
//     * @ORM\OneToMany(targetEntity="Board", mappedBy="team")
//     */
//    protected $boards;
//
//    /**
//     * @ORM\OneToMany(targetEntity="Invitation", mappedBy="team")
//     */
//    protected $invitations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
//        $this->invitations = new ArrayCollection();
//        $this->boards = new ArrayCollection();
    }

    /**
     * Get teamId
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Velocity
     * @param integer $velocity
     */
    public function setVelocity($velocity)
    {
        $this->velocity = $velocity;
    }

    /**
     * Get velocity
     * @return integer
     */
    public function getVelocity()
    {
        return $this->velocity;
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add users
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove users
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }
    
    /**
     * Set owner
     *
     * @param User $owner
     * @return Team
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
//    public function getInvitations()
//    {
//        return $this->invitations;
//    }
//
//    public function setInvitations(ArrayCollection $invitations)
//    {
//        $this->invitations = $invitations;
//    }
//
//    public function addInvitation(Invitation $invitation)
//    {
//        $this->getInvitations()->add($invitation);
//    }
//
//    /**
//     * Remove invitations
//     *
//     * @param Invitation $invitations
//     */
//    public function removeInvitation(Invitation $invitations)
//    {
//        $this->invitations->removeElement($invitations);
//    }
//
//    
//
//    /**
//     * Add boards
//     *
//     * @param itsallagile\CoreBundle\Entity\Board $boards
//     * @return Team
//     */
//    public function addBoard(\itsallagile\CoreBundle\Entity\Board $boards)
//    {
//        $this->boards[] = $boards;
//
//        return $this;
//    }
//
//    /**
//     * Remove boards
//     *
//     * @param itsallagile\CoreBundle\Entity\Board $boards
//     */
//    public function removeBoard(\itsallagile\CoreBundle\Entity\Board $boards)
//    {
//        $this->boards->removeElement($boards);
//    }
//
//    /**
//     * Get boards
//     *
//     * @return Doctrine\Common\Collections\Collection
//     */
//    public function getBoards()
//    {
//        return $this->boards;
//    }
//
//    public function getArray()
//    {
//        $data = array(
//            'id' => $this->teamId,
//            'name' => $this->name,
//            'owner' => $this->owner->getArray()
//        );
//
//        return $data;
//    }

    /**
     * Add users
     *
     * @param itsallagile\CoreBundle\Document\User $users
     */
    public function addUsers(\itsallagile\CoreBundle\Document\User $users)
    {
        $this->users[] = $users;
    }
}
