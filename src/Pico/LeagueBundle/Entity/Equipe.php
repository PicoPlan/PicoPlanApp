<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\LeagueBundle\Entity\EquipeRepository")
 */
class Equipe
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
    private $sport;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pico\LeagueBundle\Entity\Club")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="liste_modo", type="text")
     */
    private $listeModo;


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
     * Set sport
     *
     * @param integer $sport
     * @return Equipe
     */
    public function setSport($sport)
    {
        $this->sport = $sport;
    
        return $this;
    }
    /**
     * Get sport
     *
     * @return integer
     */
    public function getSport()
    {
        return $this->sport;
    }
    
    /**
     * Set club
     *
     * @param integer $club
     * @return Equipe
     */
    public function setClub($club)
    {
        $this->club = $club;
    
        return $this;
    }
    /**
     * Get club
     *
     * @return integer
     */
    public function getClub()
    {
        return $this->club;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return Equipe
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
     * Set listeModo
     *
     * @param string $listeModo
     * @return Equipe
     */
    public function setListeModo($listeModo)
    {
        $this->listeModo = $listeModo;

        return $this;
    }

    /**
     * Get listeModo
     *
     * @return string 
     */
    public function getListeModo()
    {
        return $this->listeModo;
    }
}
