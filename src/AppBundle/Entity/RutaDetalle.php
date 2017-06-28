<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * RutaDetalle
 *
 * @ORM\Table(name="ruta_detalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RutaDetalleRepository")
 */
class RutaDetalle
{
    /**
     * @var int
     *
     * @ORM\Column(name="rde_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rde_longitud", type="string", length=255)
     * @JMS\SerializedName("longitude")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $rdeLongitud;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rde_latitud", type="string", length=255)
     * @JMS\SerializedName("latitude")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $rdeLatitud;

    /**
     * @var string
     *
     * @ORM\Column(name="rde_comentario", type="text")
     * @JMS\SerializedName("comentario")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $rdeComentario;
    
    /**
     * @var string
     * @ORM\Column(name="rde_estado", type="string", length=255)
     * @JMS\SerializedName("estado")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $rdeEstado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ruta", inversedBy="rutaDetalle" )
     * @ORM\JoinColumn(name="rta_id", referencedColumnName="rta_id")
     */
    protected $ruta;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="rutas" )
     * @ORM\JoinColumn(name="cli_id", referencedColumnName="cli_id")
     * @JMS\SerializedName("ruta_cliente")
     * @JMS\Groups({"r_ruta_cliente"})
     */
    protected $cliente;

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
     * Set rdeLongitud
     *
     * @param string $rdeLongitud
     *
     * @return RutaDetalle
     */
    public function setRdeLongitud($rdeLongitud)
    {
        $this->rdeLongitud = $rdeLongitud;

        return $this;
    }

    /**
     * Get rdeLongitud
     *
     * @return string
     */
    public function getRdeLongitud()
    {
        return $this->rdeLongitud;
    }

    /**
     * Set rdeLatitud
     *
     * @param string $rdeLatitud
     *
     * @return RutaDetalle
     */
    public function setRdeLatitud($rdeLatitud)
    {
        $this->rdeLatitud = $rdeLatitud;

        return $this;
    }

    /**
     * Get rdeLatitud
     *
     * @return string
     */
    public function getRdeLatitud()
    {
        return $this->rdeLatitud;
    }

    /**
     * Set rdeComentario
     *
     * @param string $rdeComentario
     *
     * @return RutaDetalle
     */
    public function setRdeComentario($rdeComentario)
    {
        $this->rdeComentario = $rdeComentario;

        return $this;
    }

    /**
     * Get rdeComentario
     *
     * @return string
     */
    public function getRdeComentario()
    {
        return $this->rdeComentario;
    }

    /**
     * Set rdeEstado
     *
     * @param string $rdeEstado
     *
     * @return RutaDetalle
     */
    public function setRdeEstado($rdeEstado)
    {
        $this->rdeEstado = $rdeEstado;

        return $this;
    }

    /**
     * Get rdeEstado
     *
     * @return string
     */
    public function getRdeEstado()
    {
        return $this->rdeEstado;
    }

    /**
     * Set ruta
     *
     * @param \AppBundle\Entity\Ruta $ruta
     *
     * @return RutaDetalle
     */
    public function setRuta(\AppBundle\Entity\Ruta $ruta = null)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return \AppBundle\Entity\Ruta
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return RutaDetalle
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
}
