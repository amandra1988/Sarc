<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * CentroDeAcopio
 *
 * @ORM\Table(name="centro_de_acopio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CentroDeAcopioRepository")
 */
class CentroDeAcopio
{
    /**
     * @var int
     *
     * @ORM\Column(name="cen_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_centro")
     * @JMS\Groups({"centro_detalle","centro_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cen_nombre", type="string", length=255)
     * @JMS\SerializedName("nombre_centro")
     * @JMS\Groups({"centro_detalle","centro_lista"})
     */
    private $cenNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="cen_direccion", type="string", length=255)
     * @JMS\SerializedName("direccion_centro")
     * @JMS\Groups({"centro_lista"})
     */
    private $cenDireccion;

    /**
     * @var int
     *
     * @ORM\Column(name="cen_numero", type="integer")
     * @JMS\SerializedName("numero_centro")
     * @JMS\Groups({"centro_lista"})
     */
    private $cenNumero;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="cen_visible", type="boolean")
     */
    private $cenVisible;

    /**
     * @ORM\ManyToOne(targetEntity="Comuna", inversedBy="centrosDeAcopio" )
     * @ORM\JoinColumn(name="com_id", referencedColumnName="com_id")
     * @JMS\SerializedName("comuna")
     * @JMS\Groups({"centro_lista"})
     */
    protected $comuna;

    /**
     * @ORM\OneToMany(targetEntity="Empresa", mappedBy="centroDeAcopio", cascade={"persist", "remove"} )
     */
    protected  $empresas;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="cen_longitud", type="string", length=255)
     * @JMS\SerializedName("longitud_centro")
     * @JMS\Groups({"centro_lista"})
     */
    private $cenLongitud;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cen_latitud", type="string", length=255)
     * @JMS\SerializedName("latitud_centro")
     * @JMS\Groups({"centro_lista"})
     */
    private $cenLatitud;
    
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
     * Set cenNombre
     *
     * @param string $cenNombre
     *
     * @return CentroDeAcopio
     */
    public function setCenNombre($cenNombre)
    {
        $this->cenNombre = $cenNombre;

        return $this;
    }

    /**
     * Get cenNombre
     *
     * @return string
     */
    public function getCenNombre()
    {
        return $this->cenNombre;
    }

    /**
     * Set cenDireccion
     *
     * @param string $cenDireccion
     *
     * @return CentroDeAcopio
     */
    public function setCenDireccion($cenDireccion)
    {
        $this->cenDireccion = $cenDireccion;

        return $this;
    }

    /**
     * Get cenDireccion
     *
     * @return string
     */
    public function getCenDireccion()
    {
        return $this->cenDireccion;
    }

    /**
     * Set cenNumero
     *
     * @param string $cenNumero
     *
     * @return CentroDeAcopio
     */
    public function setCenNumero($cenNumero)
    {
        $this->cenNumero = $cenNumero;

        return $this;
    }

    /**
     * Get cenNumero
     *
     * @return string
     */
    public function getCenNumero()
    {
        return $this->cenNumero;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return CentroDeAcopio
     */
    public function addEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     */
    public function removeEmpresa(\AppBundle\Entity\Empresa $empresa)
    {
        $this->empresas->removeElement($empresa);
    }

    /**
     * Get empresas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }

    /**
     * Set comuna
     *
     * @param \AppBundle\Entity\Comuna $comuna
     *
     * @return CentroDeAcopio
     */
    public function setComuna(\AppBundle\Entity\Comuna $comuna = null)
    {
        $this->comuna = $comuna;

        return $this;
    }

    /**
     * Get comuna
     *
     * @return \AppBundle\Entity\Comuna
     */
    public function getComuna()
    {
        return $this->comuna;
    }

    /**
     * Set cenVisible
     *
     * @param integer $cenVisible
     *
     * @return CentroDeAcopio
     */
    public function setCenVisible($cenVisible)
    {
        $this->cenVisible = $cenVisible;

        return $this;
    }

    /**
     * Get cenVisible
     *
     * @return integer
     */
    public function getCenVisible()
    {
        return $this->cenVisible;
    }

    /**
     * Set cenLongitud
     *
     * @param string $cenLongitud
     *
     * @return CentroDeAcopio
     */
    public function setCenLongitud($cenLongitud)
    {
        $this->cenLongitud = $cenLongitud;

        return $this;
    }

    /**
     * Get cenLongitud
     *
     * @return string
     */
    public function getCenLongitud()
    {
        return $this->cenLongitud;
    }

    /**
     * Set cenLatitud
     *
     * @param string $cenLatitud
     *
     * @return CentroDeAcopio
     */
    public function setCenLatitud($cenLatitud)
    {
        $this->cenLatitud = $cenLatitud;

        return $this;
    }

    /**
     * Get cenLatitud
     *
     * @return string
     */
    public function getCenLatitud()
    {
        return $this->cenLatitud;
    }
}
