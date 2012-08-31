<?php

namespace Dvp\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dvp\TeamBundle\Entity\Section
 * 
 * A section (like Qt or PyQt), to allow for different pages (one per section). 
 *
 * @ORM\Table(name="sf2_team_section")
 * @ORM\Entity
 */
class Section
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
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var integer $gabId
     *
     * @ORM\Column(type="integer")
     */
    private $gabId;

    /**
     * @var string $image
     *
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @var string $text
     *
     * @ORM\Column(type="text", length=255)
     */
    private $text;
    
    /**
     * @var array $members
     * 
     * @ORM\ManyToMany(targetEntity="Member", mappedBy="sections")
     */ 
    private $members;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Section
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Section
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set gabId
     *
     * @param string $gabId
     * @return Section
     */
    public function setGabId($gabId)
    {
        $this->gabId = $gabId;
    
        return $gabId;
    }

    /**
     * Get gabId
     *
     * @return string 
     */
    public function getGabId()
    {
        return $this->gabId;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Section
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Section
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $text;
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
     * Add members
     *
     * @param Dvp\TeamBundle\Entity\Member $members
     * @return Section
     */
    public function addMember(\Dvp\TeamBundle\Entity\Member $members)
    {
        $this->members[] = $members;
    
        return $this;
    }

    /**
     * Remove members
     *
     * @param Dvp\TeamBundle\Entity\Member $members
     */
    public function removeMember(\Dvp\TeamBundle\Entity\Member $members)
    {
        $this->members->removeElement($members);
    }

    /**
     * Get members
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }
}