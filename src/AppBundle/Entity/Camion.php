<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Camion
 *
 * @ORM\Table(name="camion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CamionRepository")
 */
class Camion
{
    /**
     * @var int
     *
     * @ORM\Column(name="cam_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cam_patente", type="string", length=10)
     * @JMS\SerializedName("patente_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camPatente;

    /**
     * @var int
     *
     * @ORM\Column(name="cam_capacidad", type="integer")
     * @JMS\SerializedName("capacidad_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camCapacidad;

    /**
     * @var int
     * 1.-Simple, 2.- Peligrosa
     * @ORM\Column(name="cam_tipo_carga", type="integer")
     * @JMS\SerializedName("tipo_carga_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camTipoCarga;
    
    
    /**
     * @var bool
     *
     * @ORM\Column(name="cam_visible", type="boolean")
     */
    private $camVisible;
    
    /**
     * @var bool
     * 0.- Fuera de circulación, 1.- Ok 
     * @ORM\Column(name="cam_estado", type="boolean")
     * @JMS\SerializedName("estado_camion")
     * @JMS\Groups({"camion_detalle","camion_lista"})
     */
    private $camEstado;
       
    /**
     * @ORM\OneToOne(targetEntity="Operador", mappedBy="camion")
     * @JMS\SerializedName("camion_operador")
     * @JMS\Groups({"r_camion_operador"})
     */
    protected $operador;
    
    /**
     * @ORM\OneToMany(targetEntity="Ruta", mappedBy="camion", cascade={"persist", "remove"} )
     */
    protected $rutas;

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
     * Set camPatente
     *
     * @param string $camPatente
     *
     * @return Camion
     */
    public function setCamPatente($camPatente)
    {
        if($camPatente){
            $this->camPatente = $camPatente;
        }
        return $this;
    }

    /**
     * Get camPatente
     *
     * @return string
     */
    public function getCamPatente()
    {
        return $this->camPatente;
    }

    /**
     * Set camCapacidad
     *
     * @param integer $camCapacidad
     *
     * @return Camion
     */
    public function setCamCapacidad($camCapacidad)
    {
        if($camCapacidad){
            $this->camCapacidad = $camCapacidad;
        }
        return $this;
    }

    /**
     * Get camCapacidad
     *
     * @return int
     */
    public function getCamCapacidad()
    {
        return $this->camCapacidad;
    }

    /**
     * Set camTipoCarga
     *
     * @param boolean $camTipoCarga
     *
     * @return Camion
     */
    public function setCamTipoCarga($camTipoCarga)
    {
        if($camTipoCarga){
            $this->camTipoCarga = $camTipoCarga;
        }
        return $this;
    }

    /**
     * Get camTipoCarga
     *
     * @return bool
     */
    public function getCamTipoCarga()
    {
        return $this->camTipoCarga;
    }

    /**
     * Set camEstado
     *
     * @param boolean $camEstado
     *
     * @return Camion
     */
    public function setCamEstado($camEstado)
    {
        $this->camEstado = $camEstado;

        return $this;
    }

    /**
     * Get camEstado
     *
     * @return bool
     */
    public function getCamEstado()
    {
        return $this->camEstado;
    }

    /**
     * Set camVisible
     *
     * @param boolean $camVisible
     *
     * @return Camion
     */
    public function setCamVisible($camVisible)
    {
        $this->camVisible = $camVisible;

        return $this;
    }

    /**
     * Get camVisible
     *
     * @return boolean
     */
    public function getCamVisible()
    {
        return $this->camVisible;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rutas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ruta
     *
     * @param \AppBundle\Entity\Ruta $ruta
     *
     * @return Camion
     */
    public function addRuta(\AppBundle\Entity\Ruta $ruta)
    {
        $this->rutas[] = $ruta;

        return $this;
    }

    /**
     * Remove ruta
     *
     * @param \AppBundle\Entity\Ruta $ruta
     */
    public function removeRuta(\AppBundle\Entity\Ruta $ruta)
    {
        $this->rutas->removeElement($ruta);
    }

    /**
     * Get rutas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRutas()
    {
        return $this->rutas;
    }

    /**
     * Set operador
     *
     * @param \AppBundle\Entity\Operador $operador
     *
     * @return Camion
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
