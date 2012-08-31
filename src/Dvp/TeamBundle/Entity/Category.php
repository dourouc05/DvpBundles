<?php

namespace Dvp\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dvp\TeamBundle\Entity\Section;

/**
 * Dvp\TeamBundle\Entity\Category
 * 
 * A category (regular member, redaction member, responsible for a section, old member). 
 *
 * @ORM\Table(name="sf2_team_category")
 * @ORM\Entity
 */
class Category
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
     * @var boolean $bold
     *
     * @ORM\Column(type="boolean")
     */
    private $bold;
    
    /**
     * @var array $members
     * 
     * @ORM\OneToMany(targetEntity="Member", mappedBy="category")
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
     * @return Category
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
     * Set bold
     *
     * @param boolean $bold
     * @return Category
     */
    public function setBold($bold)
    {
        $this->bold = $bold;
    
        return $this;
    }

    /**
     * Get bold
     *
     * @return boolean
     */
    public function isBold()
    {
        return $this->bold;
    }
    
    /**
     * Add members
     *
     * @param Dvp\TeamBundle\Entity\Member $members
     * @return Category
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
     * Get members in this category and a specific section. 
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMembers(Section $section = null)
    {
        if(! $section) {
            return $this->members;
        } else {
            $result = array(); 
            
            foreach($this->members as $m) {
                // if($m->getSections()->contains($section)) {
                    // $result[] = $m;
                // }
            }
            
            return $result; 
        }
    }
}