<?php
namespace itsallagile\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userId;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $username;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=255) 
     */
    protected $fullName;
    
    /** 
     * ORM\Column(type="varchar", columnDefinition="ENUM('awaitingVerification', 'Active', 'Disabled')") 
     */
    protected $status;
}