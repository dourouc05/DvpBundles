<?php

namespace Dvp\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dvp\TeamBundle\Entity\Role
 * 
 * A role (like FAQ maintainer or writer). 
 *
 * @ORM\Table(name="sf2_team_role")
 * @ORM\Entity
 */
class Role
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean $userAddable
     *
     * @ORM\Column(name="userAddable", type="boolean")
     */
    private $userAddable;


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
     * @return Role
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
     * Set userAddable
     *
     * @param boolean $userAddable
     * @return Role
     */
    public function setUserAddable($userAddable)
    {
        $this->userAddable = $userAddable;
    
        return $this;
    }

    /**
     * Get userAddable
     *
     * @return boolean 
     */
    public function getUserAddable()
    {
        return $this->userAddable;
    }
}