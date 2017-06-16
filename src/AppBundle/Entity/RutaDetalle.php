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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="det_latitud", type="string", length=255)
     * @JMS\SerializedName("latitud")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $detLatitud;

    /**
     * @var string
     *
     * @ORM\Column(name="det_longitud", type="string", length=255)
     * @JMS\SerializedName("longitud")
     * @JMS\Groups({"rutaDet_detalle"})
     */
    private $detLongitud;

    /**
     * @ORM\ManyToOne(targetEntity="Ruta", inversedBy="rutaDetalle" )
     * @ORM\JoinColumn(name="rta_id", referencedColumnName="rta_id")
     */
    protected $ruta;


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
     * Set detLatitud
     *
     * @param string $detLatitud
     *
     * @return RutaDetalle
     */
    public function setDetLatitud($detLatitud)
    {
        $this->detLatitud = $detLatitud;

        return $this;
    }

    /**
     * Get detLatitud
     *
     * @return string
     */
    public function getDetLatitud()
    {
        return $this->detLatitud;
    }

    /**
     * Set detLongitud
     *
     * @param string $detLongitud
     *
     * @return RutaDetalle
     */
    public function setDetLongitud($detLongitud)
    {
        $this->detLongitud = $detLongitud;

        return $this;
    }

    /**
     * Get detLongitud
     *
     * @return string
     */
    public function getDetLongitud()
    {
        return $this->detLongitud;
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
}
