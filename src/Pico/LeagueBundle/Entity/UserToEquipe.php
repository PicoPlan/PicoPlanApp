<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserToEquipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\LeagueBundle\Entity\UserToEquipeRepository")
 */
class UserToEquipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pico\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Pico\LeagueBundle\Entity\Equipe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipe;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="bool_accepted", type="smallint")
     */
    private $boolAccepted;


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
     * Set equipe
     *
     * @param integer $equipe
     * @return UserToEquipe
     */
    public function setEquipe($equipe)
    {
        $this->equipe = $equipe;
    
        return $this;
    }
    
    /**
     * Get equipe
     *
     * @return integer
     */
    public function getEquipe()
    {
        return $this->equipe;
    }
    
    
    /**
     * Set user
     *
     * @param integer $userCreator
     * @return UserToEquipe
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }
    
    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
    
    
    /**
     * Set boolAccepted
     *
     * @param integer $boolAccepted
     * @return UserToEquipe
     */
    public function setBoolAccepted($boolAccepted)
    {
        $this->boolAccepted = $boolAccepted;

        return $this;
    }

    /**
     * Get boolAccepted
     *
     * @return integer 
     */
    public function getBoolAccepted()
    {
        return $this->boolAccepted;
    }
}
