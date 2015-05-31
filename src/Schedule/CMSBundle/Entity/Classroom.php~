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
     * @var integer
     *
     * @ORM\Column(name="departament_id", type="integer", nullable=false)
     */
    private $departamentId;



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
     * Set departamentId
     *
     * @param integer $departamentId
     * @return Classroom
     */
    public function setDepartamentId($departamentId)
    {
        $this->departamentId = $departamentId;

        return $this;
    }

    /**
     * Get departamentId
     *
     * @return integer 
     */
    public function getDepartamentId()
    {
        return $this->departamentId;
    }

    public function __toString()
    {
        return $this->name;
    }
}
