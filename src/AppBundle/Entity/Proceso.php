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
     * @ORM\Column(name="prc_fecha", type="datetime", nullable=true)
     * @JMS\SerializedName("fecha_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcFecha;
    
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
     * Estados del proceso [0=>'En espera', 1=>'En proceso', 2=>'Error', 3=>'Finalizado']
     * @ORM\Column(name="prc_estado", type="integer")
     * @JMS\SerializedName("estado_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcEstado;


    /**
     * @var string
     * [0=>'No', 1=>'Si']
     * @ORM\Column(name="prc_validado", type="boolean")
     * @JMS\SerializedName("validado_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
     private $prcValidado;


    /**
     * @var text
     *
     * @ORM\Column(name="prc_observacion", type="text")
     * @JMS\SerializedName("observacion_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
    private $prcObservacion;

    /**
     * @var datetime
     *
     * @ORM\Column(name="prc_termino", type="datetime", nullable=true)
     * @JMS\SerializedName("termino_proceso")
     * @JMS\Groups({"proceso_detalle","proceso_lista"})
     */
     private $prcTermino;

    /**
     * @ORM\OneToMany(targetEntity="Ruta", mappedBy="proceso", cascade={"persist", "remove"} )
     */
    protected  $ruta;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="procesos" )
     * @ORM\JoinColumn(name="emp_id", referencedColumnName="emp_id")
     * @JMS\SerializedName("empresa")
     * @JMS\Groups({"r_procesos_empresa"})
     */
    protected $empresa;


    /**
     * @ORM\OneToMany(targetEntity="ProcesoClientes", mappedBy="proceso")
     */
    protected $procesoClientes;

    /**
     * @ORM\OneToMany(targetEntity="ProcesoCamiones", mappedBy="proceso")
     */
    protected $procesoCamiones;

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
     * Set prcFecha
     *
     * @param \DateTime $prcFecha
     *
     * @return Proceso
     */
    public function setPrcFecha($prcFecha)
    {
        $this->prcFecha = $prcFecha;

        return $this;
    }

    /**
     * Get prcFecha
     *
     * @return \DateTime
     */
    public function getPrcFecha()
    {
        return $this->prcFecha;
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
     * @param integer $prcEstado
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
     * @return integer
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
     * Set prcTermino
     *
     * @param \DateTime $prcTermino
     *
     * @return Proceso
     */
    public function setPrcTermino($prcTermino)
    {
        $this->prcTermino = $prcTermino;

        return $this;
    }

    /**
     * Get prcTermino
     *
     * @return \DateTime
     */
    public function getPrcTermino()
    {
        return $this->prcTermino;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ruta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set prcValidado
     *
     * @param boolean $prcValidado
     *
     * @return Proceso
     */
    public function setPrcValidado($prcValidado)
    {
        $this->prcValidado = $prcValidado;

        return $this;
    }

    /**
     * Get prcValidado
     *
     * @return boolean
     */
    public function getPrcValidado()
    {
        return $this->prcValidado;
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

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Proceso
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Add procesoCliente
     *
     * @param \AppBundle\Entity\ProcesoClientes $procesoCliente
     *
     * @return Proceso
     */
    public function addProcesoCliente(\AppBundle\Entity\ProcesoClientes $procesoCliente)
    {
        $this->procesoClientes[] = $procesoCliente;

        return $this;
    }

    /**
     * Remove procesoCliente
     *
     * @param \AppBundle\Entity\ProcesoClientes $procesoCliente
     */
    public function removeProcesoCliente(\AppBundle\Entity\ProcesoClientes $procesoCliente)
    {
        $this->procesoClientes->removeElement($procesoCliente);
    }

    /**
     * Get procesoClientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProcesoClientes()
    {
        return $this->procesoClientes;
    }

    /**
     * Add procesoCamione
     *
     * @param \AppBundle\Entity\ProcesoCamiones $procesoCamione
     *
     * @return Proceso
     */
    public function addProcesoCamione(\AppBundle\Entity\ProcesoCamiones $procesoCamione)
    {
        $this->procesoCamiones[] = $procesoCamione;

        return $this;
    }

    /**
     * Remove procesoCamione
     *
     * @param \AppBundle\Entity\ProcesoCamiones $procesoCamione
     */
    public function removeProcesoCamione(\AppBundle\Entity\ProcesoCamiones $procesoCamione)
    {
        $this->procesoCamiones->removeElement($procesoCamione);
    }

    /**
     * Get procesoCamiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProcesoCamiones()
    {
        return $this->procesoCamiones;
    }
}
