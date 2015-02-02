<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leagueevent
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\LeagueeventRepository")
 */
class Leagueevent
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
     * @ORM\OneToOne(targetEntity="Pico\LeagueBundle\Entity\League")
     */
    private $league;


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
     * @return Leagueevent
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
     * @param integer $League
     * @return Leagueevent
     */
    public function setLeague($League)
    {
        $this->league = $League;

        return $this;
    }

    /**
     * Get League
     *
     * @return integer 
     */
    public function getLeague()
    {
        return $this->League;
    }

    public function setParam($id, $eventid)
    {
        $this->setEvent($eventid);
        $this->setLeague($id);
        return $this;
    }
}
