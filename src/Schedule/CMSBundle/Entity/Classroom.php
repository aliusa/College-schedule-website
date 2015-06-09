<?php

namespace Schedule\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classroom
 *
 * @ORM\Table(name="classroom", indexes={@ORM\Index(name="fk_classroom_departament1_idx", columns={"departament_id"})})
 * @ORM\Entity
 */
class Classroom
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
     * @var \Departament
     *
     * @ORM\ManyToOne(targetEntity="Departament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departament_id", referencedColumnName="id")
     * })
     */
    private $departament;



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
     * @return Classroom
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
     * Set departament
     *
     * @param \Schedule\CMSBundle\Entity\Departament $departament
     * @return Classroom
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



    public function __toString()
    {
        return $this->name;
    }
}
