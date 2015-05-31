<?php

namespace Schedule\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exam
 *
 * @ORM\Table(name="exam", indexes={@ORM\Index(name="fk_exam_faction1_idx", columns={"faction_id"}), @ORM\Index(name="fk_exam_lecturer1_idx", columns={"lecturer_id"}), @ORM\Index(name="fk_exam_course1_idx", columns={"course_id"}), @ORM\Index(name="fk_exam_classroom1_idx", columns={"classroom_id"})})
 * @ORM\Entity
 */
class Exam
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
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date", nullable=true)
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="timeStart", type="string", length=4, nullable=true)
     */
    private $timestart;

    /**
     * @var string
     *
     * @ORM\Column(name="timeEnd", type="string", length=4, nullable=true)
     */
    private $timeend;

    /**
     * @var \Classroom
     *
     * @ORM\ManyToOne(targetEntity="Classroom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classroom_id", referencedColumnName="id")
     * })
     */
    private $classroom;

    /**
     * @var \Course
     *
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * })
     */
    private $course;

    /**
     * @var \Faction
     *
     * @ORM\ManyToOne(targetEntity="Faction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="faction_id", referencedColumnName="id")
     * })
     */
    private $faction;

    /**
     * @var \Lecturer
     *
     * @ORM\ManyToOne(targetEntity="Lecturer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id")
     * })
     */
    private $lecturer;



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
     * Set day
     *
     * @param \DateTime $day
     * @return Exam
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set timestart
     *
     * @param string $timestart
     * @return Exam
     */
    public function setTimestart($timestart)
    {
        $this->timestart = $timestart;

        return $this;
    }

    /**
     * Get timestart
     *
     * @return string 
     */
    public function getTimestart()
    {
        return $this->timestart;
    }

    /**
     * Set timeend
     *
     * @param string $timeend
     * @return Exam
     */
    public function setTimeend($timeend)
    {
        $this->timeend = $timeend;

        return $this;
    }

    /**
     * Get timeend
     *
     * @return string 
     */
    public function getTimeend()
    {
        return $this->timeend;
    }

    /**
     * Set classroom
     *
     * @param \Schedule\CMSBundle\Entity\Classroom $classroom
     * @return Exam
     */
    public function setClassroom(\Schedule\CMSBundle\Entity\Classroom $classroom = null)
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get classroom
     *
     * @return \Schedule\CMSBundle\Entity\Classroom 
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * Set course
     *
     * @param \Schedule\CMSBundle\Entity\Course $course
     * @return Exam
     */
    public function setCourse(\Schedule\CMSBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Schedule\CMSBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set faction
     *
     * @param \Schedule\CMSBundle\Entity\Faction $faction
     * @return Exam
     */
    public function setFaction(\Schedule\CMSBundle\Entity\Faction $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return \Schedule\CMSBundle\Entity\Faction 
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set lecturer
     *
     * @param \Schedule\CMSBundle\Entity\Lecturer $lecturer
     * @return Exam
     */
    public function setLecturer(\Schedule\CMSBundle\Entity\Lecturer $lecturer = null)
    {
        $this->lecturer = $lecturer;

        return $this;
    }

    /**
     * Get lecturer
     *
     * @return \Schedule\CMSBundle\Entity\Lecturer 
     */
    public function getLecturer()
    {
        return $this->lecturer;
    }
}
