<?php

namespace Schedule\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faction
 *
 * @ORM\Table(name="faction", indexes={@ORM\Index(name="fk_faction_factionName_idx", columns={"factionName_id"}), @ORM\Index(name="fk_faction_form1_idx", columns={"form_id"}), @ORM\Index(name="fk_faction_departament1_idx", columns={"departament_id"})})
 * @ORM\Entity
 */
class Faction
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
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var \Departament
     *
     * @ORM\ManyToOne(targetEntity="Departament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departament_id", referencedColumnName="id")
     * })
     */
    private $departament;

    /**
     * @var \Factionname
     *
     * @ORM\ManyToOne(targetEntity="Factionname")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="factionName_id", referencedColumnName="id")
     * })
     */
    private $factionname;

    /**
     * @var \Form
     *
     * @ORM\ManyToOne(targetEntity="Form")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     * })
     */
    private $form;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="faction")
     */
    private $course;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->course = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Faction
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
     * Set email
     *
     * @param string $email
     * @return Faction
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
     * Set text
     *
     * @param string $text
     * @return Faction
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
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
     * Set departament
     *
     * @param \Schedule\CMSBundle\Entity\Departament $departament
     * @return Faction
     */
    public function setDepartament(\Schedule\CMSBundle\Entity\Departament $departament = null)
    {
        $this->departament = $departament;

        return $this;
    }

    /**
     * Get departament
     *
     * @return \Schedule\CMSBundle\Entity\Departament 
     */
    public function getDepartament()
    {
        return $this->departament;
    }

    /**
     * Set factionname
     *
     * @param \Schedule\CMSBundle\Entity\Factionname $factionname
     * @return Faction
     */
    public function setFactionname(\Schedule\CMSBundle\Entity\Factionname $factionname = null)
    {
        $this->factionname = $factionname;

        return $this;
    }

    /**
     * Get factionname
     *
     * @return \Schedule\CMSBundle\Entity\Factionname 
     */
    public function getFactionname()
    {
        return $this->factionname;
    }

    /**
     * Set form
     *
     * @param \Schedule\CMSBundle\Entity\Form $form
     * @return Faction
     */
    public function setForm(\Schedule\CMSBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Schedule\CMSBundle\Entity\Form 
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Add course
     *
     * @param \Schedule\CMSBundle\Entity\Course $course
     * @return Faction
     */
    public function addCourse(\Schedule\CMSBundle\Entity\Course $course)
    {
        $this->course[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \Schedule\CMSBundle\Entity\Course $course
     */
    public function removeCourse(\Schedule\CMSBundle\Entity\Course $course)
    {
        $this->course->removeElement($course);
    }

    /**
     * Get course
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourse()
    {
        return $this->course;
    }
}
