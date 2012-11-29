<?php
namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="teams", repositoryClass="itsallagile\CoreBundle\Repository\TeamRepository")
 */
class Team
{
    /**
     * @MongoDB\Id
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

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Get id
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
}
