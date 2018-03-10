<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Ruta
 *
 * @ORM\Table(name="ruta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RutaRepository")
 */
class Ruta
{
    /**
     * @var int
     *
     * @ORM\Column(name="rta_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 * @JMS\SerializedName("id")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rta_titulo", type="string", length=255)
	 * @JMS\SerializedName("title")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaTitulo;

    /**
     * @var \Date
     *
     * @ORM\Column(name="rta_fecha", type="date")
	 * @JMS\SerializedName("start")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaFecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Proceso", inversedBy="ruta" )
     * @ORM\JoinColumn(name="prc_id", referencedColumnName="prc_id")
     */
    protected $proceso;

    
    /**
     * @ORM\ManyToOne(targetEntity="Operador", inversedBy="rutas" )
     * @ORM\JoinColumn(name="ope_id", referencedColumnName="ope_id")
     * @JMS\SerializedName("ruta_operador")
     * @JMS\Groups({"r_ruta_operador"})
     */
    protected $operador;

    /**
     * @ORM\ManyToOne(targetEntity="Camion", inversedBy="rutas" )
     * @ORM\JoinColumn(name="cam_id", referencedColumnName="cam_id")
     * @JMS\SerializedName("ruta_camion")
     * @JMS\Groups({"r_ruta_camion"})
     */
    protected $camion;

    /**
     * @ORM\OneToMany(targetEntity="RutaDetalle", mappedBy="ruta", cascade={"persist", "remove"} )
     * @JMS\SerializedName("ruta_detalle")
     * @JMS\Groups({"r_ruta_detalle"})
     */
    protected $rutaDetalle;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rutaDetalle = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set rtaTitulo
     *
     * @param string $rtaTitulo
     *
     * @return Ruta
     */
    public function setRtaTitulo($rtaTitulo)
    {
        $this->rtaTitulo = $rtaTitulo;

        return $this;
    }

    /**
     * Get rtaTitulo
     *
     * @return string
     */
    public function getRtaTitulo()
    {
        return $this->rtaTitulo;
    }

    /**
     * Set rtaFecha
     *
     * @param \DateTime $rtaFecha
     *
     * @return Ruta
     */
    public function setRtaFecha($rtaFecha)
    {
        $this->rtaFecha = $rtaFecha;

        return $this;
    }

    /**
     * Get rtaFecha
     *
     * @return \DateTime
     */
    public function getRtaFecha()
    {
        return $this->rtaFecha;
    }

    /**
     * Set proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     *
     * @return Ruta
     */
    public function setProceso(\AppBundle\Entity\Proceso $proceso = null)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso
     *
     * @return \AppBundle\Entity\Proceso
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Set operador
     *
     * @param \AppBundle\Entity\Operador $operador
     *
     * @return Ruta
     */
    public function setOperador(\AppBundle\Entity\Operador $operador = null)
    {
        $this->operador = $operador;

        return $this;
    }

    /**
     * Get operador
     *
     * @return \AppBundle\Entity\Operador
     */
    public function getOperador()
    {
        return $this->operador;
    }

    /**
     * Set camion
     *
     * @param \AppBundle\Entity\Camion $camion
     *
     * @return Ruta
     */
    public function setCamion(\AppBundle\Entity\Camion $camion = null)
    {
        $this->camion = $camion;

        return $this;
    }

    /**
     * Get camion
     *
     * @return \AppBundle\Entity\Camion
     */
    public function getCamion()
    {
        return $this->camion;
    }

    /**
     * Add rutaDetalle
     *
     * @param \AppBundle\Entity\RutaDetalle $rutaDetalle
     *
     * @return Ruta
     */
    public function addRutaDetalle(\AppBundle\Entity\RutaDetalle $rutaDetalle)
    {
        $this->rutaDetalle[] = $rutaDetalle;

        return $this;
    }

    /**
     * Remove rutaDetalle
     *
     * @param \AppBundle\Entity\RutaDetalle $rutaDetalle
     */
    public function removeRutaDetalle(\AppBundle\Entity\RutaDetalle $rutaDetalle)
    {
        $this->rutaDetalle->removeElement($rutaDetalle);
    }

    /**
     * Get rutaDetalle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRutaDetalle()
    {
        return $this->rutaDetalle;
    }
}
