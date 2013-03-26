<?php 
namespace itsallagile\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Document\User as BaseUser;

/**
 * @MongoDB\Document(collection="users")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @JMS\Exclude     
     */
    protected $password;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $fullName;

    /**
     * @MongoDB\Field(type="string")
     * @JMS\Exclude
     */
    protected $salt;


    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }
}
