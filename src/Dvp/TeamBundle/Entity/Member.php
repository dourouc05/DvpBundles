<?php

namespace Dvp\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dvp\TeamBundle\Entity\Member
 * 
 * A member listed on a page. It can have certifications, roles, sections, and websites. 
 *
 * @ORM\Table(name="sf2_team_member")
 * @ORM\Entity
 */
class Member
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $familyName
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $familyName;

    /**
     * @var string $givenName
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $givenName;

    /**
     * @var string $pseudonym
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $pseudonym;

    /**
     * @var integer $forumId
     *
     * @ORM\Column(type="integer", unique=true)
     */
    private $forumId;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var boolean $showEmail
     *
     * @ORM\Column(type="boolean")
     */
    private $showEmail;

    /**
     * @var string $photo
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;
    
    /**
     * @var array $certifications
     *
     * @ORM\ManyToMany(targetEntity="Certification", inversedBy="members")
     * @ORM\JoinTable(name="sf2_team_member_certification")
     */
    private $certifications;
    
    /**
     * @var array $roles
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="members")
     * @ORM\JoinTable(name="sf2_team_member_role")
     */
    private $roles;
    
    /**
     * @var Category $category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    /**
     * @var array $sections
     *
     * @ORM\ManyToMany(targetEntity="Section", inversedBy="members")
     * @ORM\JoinTable(name="sf2_team_member_section")
     */
    private $sections;
    
    /**
     * @var array $websites
     *
     * @ORM\ManyToMany(targetEntity="Website", inversedBy="members")
     * @ORM\JoinTable(name="sf2_team_member_website")
     */
    private $websites;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->certifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->websites = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->pseudonym;
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
     * Set familyName
     *
     * @param string $familyName
     * @return Member
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    
        return $this;
    }

    /**
     * Get familyName
     *
     * @return string 
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Set givenName
     *
     * @param string $givenName
     * @return Member
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    
        return $this;
    }

    /**
     * Get givenName
     *
     * @return string 
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Set pseudonym
     *
     * @param string $pseudonym
     * @return Member
     */
    public function setPseudonym($pseudonym)
    {
        $this->pseudonym = $pseudonym;
    
        return $this;
    }

    /**
     * Get pseudonym
     *
     * @return string 
     */
    public function getPseudonym()
    {
        return $this->pseudonym;
    }

    /**
     * Set forumId
     *
     * @param integer $forumId
     * @return Member
     */
    public function setForumId($forumId)
    {
        $this->forumId = $forumId;
    
        return $this;
    }

    /**
     * Get forumId
     *
     * @return integer 
     */
    public function getForumId()
    {
        return $this->forumId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set showEmail
     *
     * @param boolean $showEmail
     * @return Member
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;
    
        return $this;
    }

    /**
     * Get showEmail
     *
     * @return boolean 
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Member
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add certifications
     *
     * @param Dvp\TeamBundle\Entity\Certification $certifications
     * @return Member
     */
    public function addCertification(\Dvp\TeamBundle\Entity\Certification $certifications)
    {
        $this->certifications[] = $certifications;
    
        return $this;
    }

    /**
     * Remove certifications
     *
     * @param Dvp\TeamBundle\Entity\Certification $certifications
     */
    public function removeCertification(\Dvp\TeamBundle\Entity\Certification $certifications)
    {
        $this->certifications->removeElement($certifications);
    }

    /**
     * Get certifications
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCertifications()
    {
        return $this->certifications;
    }

    /**
     * Add roles
     *
     * @param Dvp\TeamBundle\Entity\Role $roles
     * @return Member
     */
    public function addRole(\Dvp\TeamBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param Dvp\TeamBundle\Entity\Role $roles
     */
    public function removeRole(\Dvp\TeamBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set category
     *
     * @param Dvp\TeamBundle\Entity\Category $category
     * @return Member
     */
    public function setCategory(\Dvp\TeamBundle\Entity\Category $category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return Dvp\TeamBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add sections
     *
     * @param Dvp\TeamBundle\Entity\Section $sections
     * @return Member
     */
    public function addSection(\Dvp\TeamBundle\Entity\Section $sections)
    {
        $this->sections[] = $sections;
    
        return $this;
    }

    /**
     * Remove sections
     *
     * @param Dvp\TeamBundle\Entity\Section $sections
     */
    public function removeSection(\Dvp\TeamBundle\Entity\Section $sections)
    {
        $this->sections->removeElement($sections);
    }

    /**
     * Get sections
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Add websites
     *
     * @param Dvp\TeamBundle\Entity\Website $websites
     * @return Member
     */
    public function addWebsite(\Dvp\TeamBundle\Entity\Website $websites)
    {
        $this->websites[] = $websites;
    
        return $this;
    }

    /**
     * Remove websites
     *
     * @param Dvp\TeamBundle\Entity\Website $websites
     */
    public function removeWebsite(\Dvp\TeamBundle\Entity\Website $websites)
    {
        $this->websites->removeElement($websites);
    }

    /**
     * Get websites
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWebsites()
    {
        return $this->websites;
    }
}