<?php

namespace FrontofficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FrontofficeBundle\Repository\CourseRepository")
 */
class Course {

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
     * @ORM\Column(name="lenght", type="integer")
     */
    private $lenght;

    /**
     * @var integer
     *
     * @ORM\Column(name="heightDifference", type="integer")
     */
    private $heightDifference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="dificulty", type="string", length=255)
     */
    private $dificulty;

    /**
     * @var string
     *
     * @ORM\Column(name="gpx", type="text", nullable=true)
     */
    private $gpx;

    /**
     * @ORM\ManyToOne(targetEntity="Hike", inversedBy="courses")
     * @ORM\JoinColumn(name="hike_id", referencedColumnName="id")
     */
    private $hike;

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
     * Set lenght
     *
     * @param integer $lenght
     * @return Course
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;

        return $this;
    }

    /**
     * Get lenght
     *
     * @return integer 
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * Set heightDifference
     *
     * @param integer $heightDifference
     * @return Course
     */
    public function setHeightDifference($heightDifference)
    {
        $this->heightDifference = $heightDifference;

        return $this;
    }

    /**
     * Get heightDifference
     *
     * @return integer 
     */
    public function getHeightDifference()
    {
        return $this->heightDifference;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     * @return Course
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set dificulty
     *
     * @param string $dificulty
     * @return Course
     */
    public function setDificulty($dificulty)
    {
        $this->dificulty = $dificulty;

        return $this;
    }

    /**
     * Get dificulty
     *
     * @return string 
     */
    public function getDificulty()
    {
        return $this->dificulty;
    }

    /**
     * Set gpx
     *
     * @param string $gpx
     * @return Course
     */
    public function setGpx($gpx)
    {
        $this->gpx = $gpx;

        return $this;
    }

    /**
     * Get gpx
     *
     * @return string
     */
    public function getGpx()
    {
        return $this->gpx;
    }

    /**
     * Set hike
     *
     * @param \FrontofficeBundle\Entity\Hike $hike
     * @return Course
     */
    public function setHike(\FrontofficeBundle\Entity\Hike $hike = null)
    {
        $this->hike = $hike;

        return $this;
    }

    /**
     * Get hike
     *
     * @return \FrontofficeBundle\Entity\Hike 
     */
    public function getHike()
    {
        return $this->hike;
    }
}
