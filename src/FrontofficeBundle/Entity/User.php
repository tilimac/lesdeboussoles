<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FrontofficeBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FrontofficeBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="civil", type="string", length=10)
     */
    private $civil;

    /**
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @Assert\Range(
     *      min = "-100 years",
     *      max = "now"
     * )
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(name="adress1", type="string", length=255)
     */
    private $adress1;

    /**
     * @ORM\Column(name="adress2", type="string", length=255, nullable=true)
     */
    private $adress2;

    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      exactMessage = "Code postal invalide"
     * )
     * @ORM\Column(name="zip_code", type="integer", length=5)
     */
    private $zipCode;

    /**
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @Assert\Type(
     *      type="numeric",
     *      message="Numéro de téléphone invalide"
     * )
     * @Assert\Regex(
     *      pattern     = "/^0/i",
     *      message = "Numéro de téléphone invalide"
     * )
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      exactMessage = "Numéro de téléphone invalide"
     * )
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(name="mail_visible", type="boolean")
     */
    private $mailVisible = false;

    /**
     * @ORM\Column(name="phone_visible", type="boolean")
     */
    private $phoneVisible = false;

    /**
     * @ORM\Column(name="adress_visible", type="boolean")
     */
    private $adressVisible = false;

    /**
     * @ORM\OneToOne(targetEntity="Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="Your invitation is wrong", groups={"Registration"})
     */
    protected $invitation;

    public function __construct() {
        parent::__construct();
        $this->roles = array('ROLE_GUEST');
    }

    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Set adress1
     *
     * @param string $adress1
     * @return User
     */
    public function setAdress1($adress1)
    {
        $this->adress1 = $adress1;

        return $this;
    }

    /**
     * Get adress1
     *
     * @return string
     */
    public function getAdress1()
    {
        return $this->adress1;
    }

    /**
     * Set adress2
     *
     * @param string $adress2
     * @return User
     */
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get adress2
     *
     * @return string
     */
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set civil
     *
     * @param string $civil
     * @return User
     */
    public function setCivil($civil)
    {
        $this->civil = $civil;

        return $this;
    }

    /**
     * Get civil
     *
     * @return string
     */
    public function getCivil()
    {
        return $this->civil;
    }

    /**
     * Set mailVisible
     *
     * @param boolean $mailVisible
     * @return User
     */
    public function setMailVisible($mailVisible)
    {
        $this->mailVisible = $mailVisible;

        return $this;
    }

    /**
     * Get mailVisible
     *
     * @return boolean
     */
    public function getMailVisible()
    {
        return $this->mailVisible;
    }

    /**
     * Set phoneVisible
     *
     * @param boolean $phoneVisible
     * @return User
     */
    public function setPhoneVisible($phoneVisible)
    {
        $this->phoneVisible = $phoneVisible;

        return $this;
    }

    /**
     * Get phoneVisible
     *
     * @return boolean
     */
    public function getPhoneVisible()
    {
        return $this->phoneVisible;
    }

    /**
     * Set adressVisible
     *
     * @param boolean $adressVisible
     * @return User
     */
    public function setAdressVisible($adressVisible)
    {
        $this->adressVisible = $adressVisible;

        return $this;
    }

    /**
     * Get adressVisible
     *
     * @return boolean
     */
    public function getAdressVisible()
    {
        return $this->adressVisible;
    }
}
