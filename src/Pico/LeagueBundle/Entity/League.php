<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * League
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\LeagueBundle\Entity\LeagueRepository")
 */
class League
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
     * @ORM\ManyToOne(targetEntity="Pico\LeagueBundle\Entity\Sport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idSport;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pico\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreator;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


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
     * Set idSport
     *
     * @param integer $idSport
     * @return League
     */
    public function setIdSport($idSport)
    {
        $this->idSport = $idSport;
    
        return $this;
    }
    /**
     * Get idSport
     *
     * @return integer
     */
    public function getIdSport()
    {
        return $this->idSport;
    }
    
    /**
     * Set userCreator
     *
     * @param integer $userCreator
     * @return League
     */
    public function setUserCreator($userCreator)
    {
        $this->userCreator = $userCreator;
    
        return $this;
    }
    
    /**
     * Get userCreator
     *
     * @return integer
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return League
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return League
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
