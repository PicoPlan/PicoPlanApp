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
    private $idSport;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pico\LeagueBundle\Entity\Club")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idClub;
    
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
     * Set idSport
     *
     * @param integer $idSport
     * @return Equipe
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
     * Set idClub
     *
     * @param integer $idClub
     * @return Equipe
     */
    public function setIdClub($idClub)
    {
        $this->idClub = $idClub;
    
        return $this;
    }
    /**
     * Get idClub
     *
     * @return integer
     */
    public function getIdClub()
    {
        return $this->idClub;
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
