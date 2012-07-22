<?php
namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\User\EquatableInterface,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="invitation") 
 * @UniqueEntity("invitationId")
 */
class Invitation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var type 
     */
    protected $invitationId;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $sentById;
    
    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="invitations")
     * @ORM\JoinColumn(name="teamId", referencedColumnName="teamId")
     */
    protected $teamId;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=255) 
     */
    protected $token;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;
    
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }
    
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    
    public function getSentById()
    {
        return $this->sentById;
    }
    
    public function setSentById($id)
    {
        $this->sentById = $id;
    }
    
    public function getToken()
    {
        return $this->token;
    }
    
    public function setToken($token)
    {
        $this->token = $token;
    }
    
    public function getTeamId()
    {
        return $this->teamId;
    }
    
    public function setTeamId($id)
    {
        $this->teamId = $id;
    }
}