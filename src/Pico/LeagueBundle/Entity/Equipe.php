<?php
namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Equipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\LeagueBundle\Entity\EquipeRepository")
 * @UniqueEntity(fields="nom", message="Ce nom est déjà utilisé")
 *
 * @ExclusionPolicy("all")
 */
class Equipe
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
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
     *
     * @var string @ORM\Column(name="nom", type="string", length=255, unique=true)
     * @Expose
     */
    private $nom;

    /**
     *
     * @var string @ORM\Column(name="description", type="text")
     * @Expose
     */
    private $description;

    /**
     *
     * @var string @ORM\Column(name="liste_modo", type="text")
     * @Expose
     */
    private $listeModo;

    /**
    * @var integer @ORM\Column(name="score", type="integer", nullable=false)
    * @Expose
    */
    private $score;

    private $em = false;

    public function __construct($EntityManager = false)
    {
        $this->em = $EntityManager;
        if(is_null($this->getScore())) {
            $this->setScore(0);
        }
    }
    
    public function setEm($EntityManager)
    {
        $this->em = $EntityManager;
    }

    /**
     * Get idClub
     * needed by form render
     * 
     * @return integer
     */
    public function getIdClub()
    {
        if (! empty($this->club)) {
            return $this->club->getId();
        } else {
            return 0;
        }
    }

    /**
     * Set idClub
     *
     * @param integer $IdClub            
     * @return Equipe
     */
    public function setIdClub($IdClub)
    {
        // On crée l'entitée club en fonction de l'id
        $Club = $this->em->getRepository('PicoLeagueBundle:Club')->find($IdClub);
        $this->setClub($Club);
    }

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

    /**
     * Set listeModo
     *
     * @param array $listeModo            
     * @return Equipe
     */
    public function setListeModo($listeModo)
    {
        //On prépare
        if (is_array($listeModo)) {
            foreach ($listeModo as $modo) {
                if (is_object($modo)) {
                    $listeId[] = $modo->getId();
                }
            }
        } else {
            $listeId = explode(',', $listeModo);
        }
        //On passe en string
        $this->listeModo = implode(',',$listeId);
        
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

    /**
     * Set score
     *
     * @param integer $score
     * @return Equipe
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }
}
