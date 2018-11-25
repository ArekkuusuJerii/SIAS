<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participante
 *
 * @ORM\Table(name="participante", indexes={@ORM\Index(name="fk_Participante_Desarrollador1_idx", columns={"desarrollador"}), @ORM\Index(name="fk_Participante_Participante1_idx", columns={"lider"}), @ORM\Index(name="fk_Participante_Proyecto1_idx", columns={"proyecto"})})
 * @ORM\Entity
 */
class Participante
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
     * @var Desarrollador
     *
     * @ORM\ManyToOne(targetEntity="Desarrollador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="desarrollador", referencedColumnName="id")
     * })
     */
    private $desarrollador;

    /**
     * @var Participante
     *
     * @ORM\ManyToOne(targetEntity="Participante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lider", referencedColumnName="id")
     * })
     */
    private $lider;

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
     * Set desarrollador
     *
     * @param \BackendBundle\Entity\Desarrollador $desarrollador
     *
     * @return Participante
     */
    public function setDesarrollador(\BackendBundle\Entity\Desarrollador $desarrollador = null)
    {
        $this->desarrollador = $desarrollador;

        return $this;
    }

    /**
     * Get desarrollador
     *
     * @return \BackendBundle\Entity\Desarrollador
     */
    public function getDesarrollador()
    {
        return $this->desarrollador;
    }

    /**
     * Set lider
     *
     * @param \BackendBundle\Entity\Participante $lider
     *
     * @return Participante
     */
    public function setLider(\BackendBundle\Entity\Participante $lider = null)
    {
        $this->lider = $lider;

        return $this;
    }

    /**
     * Get lider
     *
     * @return \BackendBundle\Entity\Participante
     */
    public function getLider()
    {
        return $this->lider;
    }

    /**
     * Set proyecto
     *
     * @param \BackendBundle\Entity\Proyecto $proyecto
     *
     * @return Participante
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
