<?php

namespace Pico\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\UserBundle\Entity\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{

    public function __construct(){
        parent::__construct();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     * @Expose
     */
    protected $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     * @Expose
     */
    protected $first_name;

    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="integer", nullable=false)
     */
    protected $phone;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

     /**
     * Get the formatted name to display (NAME Firstname or username)
     * 
     * @param $separator: the separator between name and firstname (default: ' ')
     * @return String
     * @VirtualProperty 
     */
    public function getUsedName($separator = ' '){
        if($this->getName()!=null && $this->getFirstName()!=null){
            return ucfirst(strtolower($this->getFirstName())).$separator.strtoupper($this->getName());
        }
        else{
            return $this->getUsername();
        }
    }
}
