<?php

namespace Schedule\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Other
 *
 * @ORM\Table(name="other", uniqueConstraints={@ORM\UniqueConstraint(name="title_UNIQUE", columns={"title"})})
 * @ORM\Entity
 */
class Other
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Faction", mappedBy="other")
     */
    private $faction;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lecturer", mappedBy="other")
     */
    private $lecturer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->faction = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lecturer = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Other
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add faction
     *
     * @param \Schedule\CMSBundle\Entity\Faction $faction
     * @return Other
     */
    public function addFaction(\Schedule\CMSBundle\Entity\Faction $faction)
    {
        $this->faction[] = $faction;

        return $this;
    }

    /**
     * Remove faction
     *
     * @param \Schedule\CMSBundle\Entity\Faction $faction
     */
    public function removeFaction(\Schedule\CMSBundle\Entity\Faction $faction)
    {
        $this->faction->removeElement($faction);
    }

    /**
     * Get faction
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Add lecturer
     *
     * @param \Schedule\CMSBundle\Entity\Lecturer $lecturer
     * @return Other
     */
    public function addLecturer(\Schedule\CMSBundle\Entity\Lecturer $lecturer)
    {
        $this->lecturer[] = $lecturer;

        return $this;
    }

    /**
     * Remove lecturer
     *
     * @param \Schedule\CMSBundle\Entity\Lecturer $lecturer
     */
    public function removeLecturer(\Schedule\CMSBundle\Entity\Lecturer $lecturer)
    {
        $this->lecturer->removeElement($lecturer);
    }

    /**
     * Get lecturer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLecturer()
    {
        return $this->lecturer;
    }

    public function __toString()
    {
        return $this->title;
    }
}
