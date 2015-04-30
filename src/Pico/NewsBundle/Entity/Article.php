<?php
namespace Pico\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pico\NewsBundle\Entity;

/**
* articles
*
* @ORM\Table()
* @ORM\Entity(repositoryClass="Pico\NewsBundle\Entity\ArticleRepository")
*/

class Article {

    /**
    * @var integer @ORM\Column(name="id", type="integer")
    *   @ORM\Id
    *   @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @var string @ORM\Column(name="title", type="string", length=255)
    */
    private $title;

    /**
     * @var int
     * @ORM\Column(name="imageId", type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="Pico\NewsBundle\Entity\NewsImage")
     */
    private $imageId;

    /**
    * @var string @ORM\Column(name="content", type="text")
    */
    private $content;

    /**
    * @ORM\ManyToOne(targetEntity="Pico\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=false)
    */
    private $author;

    /**
    * @var \DateTime @ORM\Column(name="date", type="datetime")
    */
    private $date;

    public function __construct(){
        $this->date = new \DateTime();
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
     * @return Article
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
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
     * Set author
     *
     * @param \Pico\UserBundle\Entity\User $author
     * @return Article
     */
    public function setAuthor(\Pico\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Pico\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set imageId
     *
     * @param integer $imageId
     * @return Article
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    /**
     * Get imageId
     *
     * @return integer 
     */
    public function getImageId()
    {
        return $this->imageId;
    }
}
