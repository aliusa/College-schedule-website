<?php

namespace Schedule\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecturer
 *
 * @ORM\Table(name="lecturer", indexes={@ORM\Index(name="fk_lecturer_prefix1_idx", columns={"prefix_id"})})
 * @ORM\Entity
 */
class Lecturer
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
     * @ORM\Column(name="firstName", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=45, nullable=false)
     */
    private $lastname;

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
     * @var \Prefix
     *
     * @ORM\ManyToOne(targetEntity="Prefix")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prefix_id", referencedColumnName="id")
     * })
     */
    private $prefix;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="lecturer")
     * @ORM\JoinTable(name="lecturer_has_course",
     *   joinColumns={
     *     @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     *   }
     * )
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
     * Set firstname
     *
     * @param string $firstname
     * @return Lecturer
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Lecturer
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Lecturer
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
     * @return Lecturer
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
     * Set prefix
     *
     * @param \Schedule\CMSBundle\Entity\Prefix $prefix
     * @return Lecturer
     */
    public function setPrefix(\Schedule\CMSBundle\Entity\Prefix $prefix = null)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return \Schedule\CMSBundle\Entity\Prefix 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Add course
     *
     * @param \Schedule\CMSBundle\Entity\Course $course
     * @return Lecturer
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

    public function __toString()
    {
        return $this->firstname." ".$this->lastname;
    }
}
