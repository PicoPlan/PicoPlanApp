<?php

namespace Pico\CalendarManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Entity(repositoryClass="Pico\CalendarManagerBundle\Entity\EventRepository")
 */
class Event
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     *@ORM\Column(type="string", length=255, unique=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", unique=false)
     */
    private $datetimeStart;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", unique=false)
     */
    private $datetimeEnd;

    /**
     * Set id
     *
     * @param integer $id
     * @return Event
     */
    public function setId($id)
    {
        $this->id= $id;

        return $this;
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
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
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
     * Set datetimeStart
     *
     * @param \DateTime $datetimeStart
     * @return Event
     */
    public function setDatetimeStart($datetimeStart)
    {
        $this->datetimeStart = $datetimeStart;

        return $this;
    }

    /**
     * Get datetimeStart
     *
     * @return \DateTime 
     */
    public function getDatetimeStart()
    {
        return $this->datetimeStart;
    }

    /**
     * Set datetimeEnd
     *
     * @param \DateTime $datetimeEnd
     * @return Event
     */
    public function setDatetimeEnd($datetimeEnd)
    {
        $this->datetimeEnd = $datetimeEnd;

        return $this;
    }

    /**
     * Get datetimeEnd
     *
     * @return \DateTime 
     */
    public function getDatetimeEnd()
    {
        return $this->datetimeEnd;
    }
}
