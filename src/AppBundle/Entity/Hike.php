<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Course;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Image;

/**
 * Hike
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HikeRepository")
 */
class Hike {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_report", type="datetime")
     */
    private $dateReport;

    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=255)
     */
    private $locality;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="integer")
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="string", length=255)
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="hike", cascade={"persist", "remove"})
     */
    public $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="canceled", type="integer")
     */
    private $canceled = 0;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="hike", cascade={"persist", "remove"})
     */
    private $courses;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->courses = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Hike
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
     * Set locality
     *
     * @param string $locality
     * @return Hike
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Hike
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return integer 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Hike
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
     * Set start
     *
     * @param string $start
     * @return Hike
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Hike
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
     * Set canceled
     *
     * @param boolean $canceled
     * @return Hike
     */
    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Get canceled
     *
     * @return boolean 
     */
    public function getCanceled()
    {
        return $this->canceled;
    }

    public function addCourse(Course $course)
    {
        $this->courses->add($course);
        $course->setHike($this);
    }

    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add images
     *
     * @param Image $images
     * @return Hike
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        $image->setHike($this);

        return $this;
    }

    public function setImages(ArrayCollection $images)
    {
        foreach ($images as $image) {
            $image->setHike($this);
        }

        $this->images = $images;
    }

    /**
     * Remove images
     *
     * @param Image $images
     */
    public function removeImage(Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set dateReport
     *
     * @param \DateTime $dateReport
     * @return Hike
     */
    public function setDateReport($dateReport)
    {
        $this->dateReport = $dateReport;

        return $this;
    }

    /**
     * Get dateReport
     *
     * @return \DateTime 
     */
    public function getDateReport()
    {
        return $this->dateReport;
    }
}
