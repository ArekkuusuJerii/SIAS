<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table(name="actividad", indexes={@ORM\Index(name="fk_Actividad_Desarrollador1_idx", columns={"responsable"}), @ORM\Index(name="fk_Actividad_Proyecto1_idx", columns={"proyecto"})})
 * @ORM\Entity
 */
class Actividad
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
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=false)
     */
    private $fechaFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin_real", type="datetime", nullable=true)
     */
    private $fechaFinReal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio_real", type="datetime", nullable=true)
     */
    private $fechaInicioReal;

    /**
     * @var Desarrollador
     *
     * @ORM\ManyToOne(targetEntity="Desarrollador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="responsable", referencedColumnName="id")
     * })
     */
    private $responsable;

    /**
     * @var Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto", referencedColumnName="id")
     * })
     */
    private $proyecto;



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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Actividad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Actividad
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set fechaFinReal
     *
     * @param \DateTime $fechaFinReal
     *
     * @return Actividad
     */
    public function setFechaFinReal($fechaFinReal)
    {
        $this->fechaFinReal = $fechaFinReal;

        return $this;
    }

    /**
     * Get fechaFinReal
     *
     * @return \DateTime
     */
    public function getFechaFinReal()
    {
        return $this->fechaFinReal;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Actividad
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaInicioReal
     *
     * @param \DateTime $fechaInicioReal
     *
     * @return Actividad
     */
    public function setFechaInicioReal($fechaInicioReal)
    {
        $this->fechaInicioReal = $fechaInicioReal;

        return $this;
    }

    /**
     * Get fechaInicioReal
     *
     * @return \DateTime
     */
    public function getFechaInicioReal()
    {
        return $this->fechaInicioReal;
    }

    /**
     * Set responsable
     *
     * @param \BackendBundle\Entity\Desarrollador $responsable
     *
     * @return Actividad
     */
    public function setResponsable(\BackendBundle\Entity\Desarrollador $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \BackendBundle\Entity\Desarrollador
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set proyecto
     *
     * @param \BackendBundle\Entity\Proyecto $proyecto
     *
     * @return Actividad
     */
    public function setProyecto(\BackendBundle\Entity\Proyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \BackendBundle\Entity\Proyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }
}
