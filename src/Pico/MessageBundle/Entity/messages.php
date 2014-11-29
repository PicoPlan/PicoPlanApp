<?php
namespace Pico\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pico\UserBundle\Entity;

/**
 * messages
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Pico\MessageBundle\Entity\messagesRepository")
 */
class messages
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pico\UserBundle\Entity\User")
     */
    private $userFrom;

    /**
     *
     * @var string @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     *
     * @var string @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     *
     * @var \DateTime @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @var integer @ORM\Column(name="top_vu", type="integer", length=1)
     */
    private $topVu;

    /**
     * @ORM\ManyToOne(targetEntity="Pico\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userTo;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->topVu = 0;
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
     * Set idFrom
     *
     * @param integer $idFrom            
     * @return messages
     */
    public function setUserFrom($idFrom)
    {
        $this->userFrom = $idFrom;
        
        return $this;
    }

    /**
     * Get idFrom
     *
     * @return integer
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set title
     *
     * @param string $title            
     * @return messages
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
     * Set text
     *
     * @param string $text            
     * @return messages
     */
    public function setText($text)
    {
        $this->text = $text;
        
        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date            
     * @return messages
     */
    public function setDate($date)
    {
        $this->date = $date;
        
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set topVu
     *
     * @param integer $topVu            
     * @return messages
     */
    public function setTopVu($topVu)
    {
        $this->topVu = $topVu;
        
        return $this;
    }

    /**
     * Get topVu
     *
     * @return integer
     */
    public function getTopVu()
    {
        return $this->topVu;
    }

    /**
     * Set userTo
     *
     * @param integer $userTo            
     * @return messages
     */
    public function setUserTo($userTo)
    {
        $this->userTo = $userTo;
        
        return $this;
    }

    /**
     * Get userTo
     *
     * @return integer
     */
    public function getUserTo()
    {
        return $this->userTo;
    }
}
