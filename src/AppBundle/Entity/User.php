<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Member;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="Your invitation is wrong", groups={"Registration"})
     */
    protected $invitation;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="user",cascade={"persist"})
     */
    private $members;

    /**
     * @ORM\Column(name="email_newsletter", type="boolean", options={"default" : 1})
     */
    private $emailNewsletter = true;

    /**
     * @ORM\Column(name="email_hike", type="boolean", options={"default" : 1})
     */
    private $emailHike = true;


    public function __construct() {
        parent::__construct();
        $this->members = new ArrayCollection();
        $this->roles = array('ROLE_GUEST');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
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
     * Add members
     *
     * @param Member $members
     * @return User
     */
    public function addMember(Member $members)
    {
        $this->members[] = $members;

        return $this;
    }

    /**
     * Remove members
     *
     * @param Member $members
     */
    public function removeMember(Member $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return Collection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set emailNewsletter
     *
     * @param boolean $emailNewsletter
     * @return User
     */
    public function setEmailNewsletter($emailNewsletter)
    {
        $this->emailNewsletter = $emailNewsletter;

        return $this;
    }

    /**
     * Get emailNewsletter
     *
     * @return boolean 
     */
    public function getEmailNewsletter()
    {
        return $this->emailNewsletter;
    }

    /**
     * Set emailHike
     *
     * @param boolean $emailHike
     * @return User
     */
    public function setEmailHike($emailHike)
    {
        $this->emailHike = $emailHike;

        return $this;
    }

    /**
     * Get emailHike
     *
     * @return boolean 
     */
    public function getEmailHike()
    {
        return $this->emailHike;
    }
}
