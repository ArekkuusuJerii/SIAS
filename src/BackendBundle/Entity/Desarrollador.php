<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Desarrollador
 *
 * @ORM\Table(name="desarrollador", indexes={@ORM\Index(name="fk_Desarrollador_Proyecto1_idx", columns={"proyecto"}), @ORM\Index(name="fk_Desarrollador_Puesto_idx", columns={"puesto"}), @ORM\Index(name="fk_Desarrollador_Usuario1_idx", columns={"usuario"})})
 * @ORM\Entity
 */
class Desarrollador
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
     * @var Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto", referencedColumnName="id")
     * })
     */
    private $proyecto;

    /**
     * @var Puesto
     *
     * @ORM\ManyToOne(targetEntity="Puesto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="puesto", referencedColumnName="id")
     * })
     */
    private $puesto;

    /**
     * @var Usuario
     *
     * @ORM\OneToOne(targetEntity="Usuario", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;



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
     * Set proyecto
     *
     * @param \BackendBundle\Entity\Proyecto $proyecto
     *
     * @return Desarrollador
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

    /**
     * Set puesto
     *
     * @param \BackendBundle\Entity\Puesto $puesto
     *
     * @return Desarrollador
     */
    public function setPuesto(\BackendBundle\Entity\Puesto $puesto = null)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return \BackendBundle\Entity\Puesto
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set usuario
     *
     * @param \BackendBundle\Entity\Usuario $usuario
     *
     * @return Desarrollador
     */
    public function setUsuario(\BackendBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \BackendBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
