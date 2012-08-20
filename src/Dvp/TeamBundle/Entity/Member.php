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
     * @ORM\Column(name="familyName", type="string", length=255, nullable=true)
     */
    private $familyName;

    /**
     * @var string $givenName
     *
     * @ORM\Column(name="givenName", type="string", length=255, nullable=true)
     */
    private $givenName;

    /**
     * @var string $pseudonym
     *
     * @ORM\Column(name="pseudonym", type="string", length=255, unique=true)
     */
    private $pseudonym;

    /**
     * @var integer $forumId
     *
     * @ORM\Column(name="forumId", type="integer", unique=true)
     */
    private $forumId;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var boolean $showEmail
     *
     * @ORM\Column(name="show_email", type="boolean")
     */
    private $showEmail;
    
    /**
     * @var array $certifications
     *
     * @ORM\ManyToMany(targetEntity="Certification")
     * @ORM\JoinTable(name="sf2_team_member_certification")
     */
    private $certifications;
    
    /**
     * @var array $roles
     *
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="sf2_team_member_role")
     */
    private $roles;
    
    /**
     * @var Category $category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    /**
     * @var array $websites
     *
     * @ORM\OneToMany(targetEntity="Website", mappedBy="member")
     */
    private $websites;
    
    /**
     * @var array $sections
     *
     * @ORM\OneToMany(targetEntity="Section")
     * @ORM\Column(nullable=false)
     */
    private $sections;


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
     * @param string $family name
     * @return Member
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    
        return $this;
    }

    /**
     * Get family name
     *
     * @return string 
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Set given name
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
     * Get given name
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
     * Set forum id
     *
     * @param integer $forumId
     * @return integer 
     */
    public function setForumId($forumId)
    {
        $this->forumId = $forumId;
    
        return $this;
    }
    
    /**
     * Get forum id
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
     * Constructor
     */
    public function __construct()
    {
        $this->certifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set sections
     *
     * @param string $sections
     * @return Member
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    
        return $this;
    }

    /**
     * Get sections
     *
     * @return string 
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
}