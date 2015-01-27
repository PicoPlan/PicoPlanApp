<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clubevent
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\ClubeventRepository")
 */
class Clubevent
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
     * @ORM\OneToOne(targetEntity="Pico\LeagueBundle\Entity\Club")
     */
    private $club;


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
     * @return Clubevent
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
     * Set club
     *
     * @param integer $club
     * @return Clubevent
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

    public function setParam($id, $eventid)
    {
        $this->setEvent($eventid);
        $this->setClub($id);
        return $this;
    }
}
