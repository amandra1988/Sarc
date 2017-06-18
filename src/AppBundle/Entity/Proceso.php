<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Proceso
 *
 * @ORM\Table(name="proceso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesoRepository")
 */
class Proceso
{
    /**
     * @var int
     *
     * @ORM\Column(name="prc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="prc_inicio", type="datetime")
     * @JMS\SerializedName("inicio_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcFechaInicio;


    /**
     * @var datetime
     *
     * @ORM\Column(name="prc_termino", type="datetime")
     * @JMS\SerializedName("termino_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcFechaTermino;
    
    /**
     * @var int
     *
     * @ORM\Column(name="prc_cantidad_clientes", type="integer")
     * @JMS\SerializedName("cant_clientes_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcCantidadClientes;
    
     /**
     * @var string
     * @ORM\Column(name="prc_estado", type="string", length=255)
     * @JMS\SerializedName("estado_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcEstado;
    
    /**
     * @var text
     *
     * @ORM\Column(name="prc_observacion", type="text")
     * @JMS\SerializedName("observacion_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcObservacion;
    
    /**
     * @ORM\OneToMany(targetEntity="Ruta", mappedBy="proceso", cascade={"persist", "remove"} )
     */
    protected  $ruta;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ruta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set prcFechaInicio
     *
     * @param \DateTime $prcFechaInicio
     *
     * @return Proceso
     */
    public function setPrcFechaInicio($prcFechaInicio)
    {
        $this->prcFechaInicio = $prcFechaInicio;

        return $this;
    }

    /**
     * Get prcFechaInicio
     *
     * @return \DateTime
     */
    public function getPrcFechaInicio()
    {
        return $this->prcFechaInicio;
    }

    /**
     * Set prcFechaTermino
     *
     * @param \DateTime $prcFechaTermino
     *
     * @return Proceso
     */
    public function setPrcFechaTermino($prcFechaTermino)
    {
        $this->prcFechaTermino = $prcFechaTermino;

        return $this;
    }

    /**
     * Get prcFechaTermino
     *
     * @return \DateTime
     */
    public function getPrcFechaTermino()
    {
        return $this->prcFechaTermino;
    }

    /**
     * Set prcCantidadClientes
     *
     * @param integer $prcCantidadClientes
     *
     * @return Proceso
     */
    public function setPrcCantidadClientes($prcCantidadClientes)
    {
        $this->prcCantidadClientes = $prcCantidadClientes;

        return $this;
    }

    /**
     * Get prcCantidadClientes
     *
     * @return integer
     */
    public function getPrcCantidadClientes()
    {
        return $this->prcCantidadClientes;
    }

    /**
     * Set prcEstado
     *
     * @param string $prcEstado
     *
     * @return Proceso
     */
    public function setPrcEstado($prcEstado)
    {
        $this->prcEstado = $prcEstado;

        return $this;
    }

    /**
     * Get prcEstado
     *
     * @return string
     */
    public function getPrcEstado()
    {
        return $this->prcEstado;
    }

    /**
     * Set prcObservacion
     *
     * @param string $prcObservacion
     *
     * @return Proceso
     */
    public function setPrcObservacion($prcObservacion)
    {
        $this->prcObservacion = $prcObservacion;

        return $this;
    }

    /**
     * Get prcObservacion
     *
     * @return string
     */
    public function getPrcObservacion()
    {
        return $this->prcObservacion;
    }

    /**
     * Add rutum
     *
     * @param \AppBundle\Entity\Ruta $rutum
     *
     * @return Proceso
     */
    public function addRutum(\AppBundle\Entity\Ruta $rutum)
    {
        $this->ruta[] = $rutum;

        return $this;
    }

    /**
     * Remove rutum
     *
     * @param \AppBundle\Entity\Ruta $rutum
     */
    public function removeRutum(\AppBundle\Entity\Ruta $rutum)
    {
        $this->ruta->removeElement($rutum);
    }

    /**
     * Get ruta
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRuta()
    {
        return $this->ruta;
    }
}
