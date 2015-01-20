<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupevent
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\GroupeventRepository")
 */
class Groupevent
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Pico\CalendarManagerBundle\Entity\Event")
     */
    private $event;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Pico\LeagueBundle\Entity\Equipe")
     */
    private $equipe;


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
     * Set event
     *
     * @param integer $event
     * @return Groupevent
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return integer 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set equipe
     *
     * @param integer $equipe
     * @return Groupevent
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

    public function setParam($id, $eventid)
    {
        $this->setEvent($eventid);
        $this->setUser($id);
        return $this;
    }
}
