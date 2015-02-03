<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repeatingevent
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\RepeatingeventventRepository")
 */
class Repeatingevent
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Pico\CalendarManagerBundle\Entity\Event", cascade={"persist"})
     */
    private $event;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $weekday;

    /**
     * @var \DateTime
     */
    private $dateStartrepeat;

    /**
     * @var \DateTime
     */
    private $dateEndrepeat;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=false)
     */
    private $frequency;


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
     * Set weekday
     *
     * @param integer $weekday
     * @return Repeatingevent
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return integer 
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * Set dateStartrepeat
     *
     * @param \DateTime $dateStartrepeat
     * @return Repeatingevent
     */
    public function setDateStartrepeat($dateStartrepeat)
    {
        $this->dateStartrepeat = $dateStartrepeat;

        return $this;
    }

    /**
     * Get dateStartrepeat
     *
     * @return \DateTime 
     */
    public function getDateStartrepeat()
    {
        return $this->dateStartrepeat;
    }

    /**
     * Set dateEndrepeat
     *
     * @param \DateTime $dateEndrepeat
     * @return Repeatingevent
     */
    public function setDateEndrepeat($dateEndrepeat)
    {
        $this->dateEndrepeat = $dateEndrepeat;

        return $this;
    }

    /**
     * Get dateEndrepeat
     *
     * @return \DateTime 
     */
    public function getDateEndrepeat()
    {
        return $this->dateEndrepeat;
    }

    /**
     * Set frequency
     *
     * @param string $frequency
     * @return Repeatingevent
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return string 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set event
     *
     * @param integer $event
     * @return Repeatingevent
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

}
