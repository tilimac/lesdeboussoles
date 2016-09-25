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
 * @ORM\Entity(repositoryClass="FrontofficeBundle\Repository\MemberRepository")
 */
class Member {

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
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;

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
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * @return Member
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
     * Set mail
     *
     * @param integer $mail
     * @return Member
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return integer
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set civil
     *
     * @param string $civil
     * @return Member
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Member
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}
