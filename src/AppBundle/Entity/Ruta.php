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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 * @JMS\SerializedName("ruta_id")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rta_latitud", type="string", length=255)
	 * @JMS\SerializedName("ruta_latitud")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaLatitud;

    /**
     * @var string
     *
     * @ORM\Column(name="rta_longitud", type="string", length=255)
	 * @JMS\SerializedName("ruta_longitud")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaLongitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rta_fecha", type="date")
	 * @JMS\SerializedName("ruta_fecha")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaFecha;

    /**
     * @var int
     *
     * @ORM\Column(name="rta_realizado", type="integer")
	 * @JMS\SerializedName("ruta_realizado")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaRealizado;

    /**
     * @var string
     *
     * @ORM\Column(name="rta_observacion", type="string", length=255)
	 * @JMS\SerializedName("ruta_observacion")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    private $rtaObservacion;

  
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="rutas" )
     * @ORM\JoinColumn(name="cli_id", referencedColumnName="cli_id")
     * @JMS\SerializedName("ruta_cliente")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    protected $cliente;
	

    /**
     * @ORM\ManyToOne(targetEntity="Operador", inversedBy="rutas" )
     * @ORM\JoinColumn(name="ope_id", referencedColumnName="ope_id")
     * @JMS\SerializedName("ruta_operador")
     * @JMS\Groups({"ruta_detalle","ruta_lista"})
     */
    protected $operador;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rtaLatitud
     *
     * @param string $rtaLatitud
     *
     * @return Ruta
     */
    public function setRtaLatitud($rtaLatitud)
    {
        $this->rtaLatitud = $rtaLatitud;

        return $this;
    }

    /**
     * Get rtaLatitud
     *
     * @return string
     */
    public function getRtaLatitud()
    {
        return $this->rtaLatitud;
    }

    /**
     * Set rtaLongitud
     *
     * @param string $rtaLongitud
     *
     * @return Ruta
     */
    public function setRtaLongitud($rtaLongitud)
    {
        $this->rtaLongitud = $rtaLongitud;

        return $this;
    }

    /**
     * Get rtaLongitud
     *
     * @return string
     */
    public function getRtaLongitud()
    {
        return $this->rtaLongitud;
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
     * Set rtaRealizado
     *
     * @param boolean $rtaRealizado
     *
     * @return Ruta
     */
    public function setRtaRealizado($rtaRealizado)
    {
        $this->rtaRealizado = $rtaRealizado;

        return $this;
    }

    /**
     * Get rtaRealizado
     *
     * @return bool
     */
    public function getRtaRealizado()
    {
        return $this->rtaRealizado;
    }

    /**
     * Set rtaObservacion
     *
     * @param string $rtaObservacion
     *
     * @return Ruta
     */
    public function setRtaObservacion($rtaObservacion)
    {
        $this->rtaObservacion = $rtaObservacion;

        return $this;
    }

    /**
     * Get rtaObservacion
     *
     * @return string
     */
    public function getRtaObservacion()
    {
        return $this->rtaObservacion;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Ruta
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
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
}
