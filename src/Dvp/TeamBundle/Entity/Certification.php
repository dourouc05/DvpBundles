<?php

namespace Dvp\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dvp\TeamBundle\Entity\Certification
 * 
 * A certification (like Qt Curriculum Essential).
 *
 * @ORM\Table(name="sf2_team_certification")
 * @ORM\Entity
 */
class Certification
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
     * @var string $imageUrl
     *
     * @ORM\Column(name="image_url", type="string", length=255)
     */
    private $imageUrl;


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
     * @return Certification
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
     * Set image_url
     *
     * @param string $imageUrl
     * @return Certification
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    
        return $this;
    }

    /**
     * Get image_url
     *
     * @return string 
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}