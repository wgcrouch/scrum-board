<?php
namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use itsallagile\CoreBundle\Entity\Invitation;
use itsallagile\CoreBundle\Entity\Team;
use itsallagile\CoreBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="team")
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $teamId;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="userId")
     */
    protected $owner;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    protected $velocity;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="teams")
     *
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Board", mappedBy="team")
     */
    protected $boards;

    /**
     * @ORM\OneToMany(targetEntity="Invitation", mappedBy="team")
     */
    protected $invitations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->boards = new ArrayCollection();
    }

    /**
     * Get teamId
     * @return integer
     */
    public function getTeamId()
    {
        return $this->teamId;
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

    public function getInvitations()
    {
        return $this->invitations;
    }

    public function setInvitations(ArrayCollection $invitations)
    {
        $this->invitations = $invitations;
    }

    public function addInvitation(Invitation $invitation)
    {
        $this->getInvitations()->add($invitation);
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
     * Remove invitations
     *
     * @param Invitation $invitations
     */
    public function removeInvitation(Invitation $invitations)
    {
        $this->invitations->removeElement($invitations);
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

    /**
     * Add boards
     *
     * @param itsallagile\CoreBundle\Entity\Board $boards
     * @return Team
     */
    public function addBoard(\itsallagile\CoreBundle\Entity\Board $boards)
    {
        $this->boards[] = $boards;

        return $this;
    }

    /**
     * Remove boards
     *
     * @param itsallagile\CoreBundle\Entity\Board $boards
     */
    public function removeBoard(\itsallagile\CoreBundle\Entity\Board $boards)
    {
        $this->boards->removeElement($boards);
    }

    /**
     * Get boards
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getBoards()
    {
        return $this->boards;
    }

    public function getArray()
    {
        $data = array(
            'id' => $this->teamId,
            'name' => $this->name,
            'owner' => $this->owner->getArray()
        );

        return $data;
    }
}
