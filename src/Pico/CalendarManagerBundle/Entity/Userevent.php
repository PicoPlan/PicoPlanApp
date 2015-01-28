<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userevent
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\UsereventRepository")
 */
class Userevent
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
     * @ORM\OneToOne(targetEntity="Pico\UserBundle\Entity\User")
     */
    private $user;


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
     * @return Userevent
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
     * Set user
     *
     * @param integer $user
     * @return Userevent
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

    public function setParam($id, $eventid)
    {
        $this->setEvent($eventid);
        $this->setUser($id);
        return $this;
    }
}
