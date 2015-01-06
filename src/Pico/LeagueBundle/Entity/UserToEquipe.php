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
