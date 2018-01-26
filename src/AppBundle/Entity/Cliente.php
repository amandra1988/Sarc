<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @var int
     *
     * @ORM\Column(name="cli_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("cliente_id")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_nombre", type="string", length=100)
     *  @JMS\SerializedName("cliente_nombre")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $cliNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_direccion", type="string", length=255)
     * @JMS\SerializedName("cliente_direccion")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $cliDireccion;

    /**
     * @var int
     *
     * @ORM\Column(name="cli_telefono", type="integer", length=9, nullable=true)
     * @JMS\SerializedName("cliente_telefono")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $cliTelefono;

    /**
     * @var int
     *
     * @ORM\Column(name="cli_celular", type="integer", length=9, nullable=true)
     * @JMS\SerializedName("cliente_celular")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $cliCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_correo", type="string", length=100, nullable=true)
     * @JMS\SerializedName("cliente_correo")
     * @JMS\Groups({"cliente_detalle","cliente_lista"})
     */
    private $cliCorreo;

    /**
     * @var bool
     *
     * @ORM\Column(name="cli_visible", type="boolean")
     */
    private $cliVisible;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_longitud", type="string", length=100)
     * @JMS\SerializedName("cliente_longitud")
     * @JMS\Groups({"cliente_lista"})
     */
    private $cliLongitud;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_latitud", type="string", length=100)
     * @JMS\SerializedName("cliente_latitud")
     * @JMS\Groups({"cliente_lista"})
     */
    private $cliLatitud;

    /**
     * @var string
     *
     * @ORM\Column(name="cli_theta", type="string", length=20)
     * @JMS\SerializedName("cliente_theta")
     * @JMS\Groups({"cliente_lista"})
     */
     private $cliTheta;

    
     /**
     * @var int
     *
     * @ORM\Column(name="cli_demanda", type="string", length=5 )
     * @JMS\SerializedName("cliente_demanda")
     * @JMS\Groups({"cliente_lista"})
     */
    private $cliDemanda;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Frecuencia", inversedBy="clientes" )
     * @ORM\JoinColumn(name="fre_id", referencedColumnName="fre_id")
     * @JMS\SerializedName("cliente_frecuencia")
     * @JMS\Groups({"cliente_lista"})
     */
    protected $frecuencia;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="cliente" )
     * @ORM\JoinColumn(name="usr_id", referencedColumnName="id")
     * @JMS\SerializedName("usuario")
     * @JMS\Groups({"r_cliente_usuario"})
     */
    protected $usuario;
        
    /**
     * @ORM\ManyToOne(targetEntity="Comuna", inversedBy="clientes" )
     * @ORM\JoinColumn(name="com_id", referencedColumnName="com_id")
     * @JMS\SerializedName("comuna")
     * @JMS\Groups({"r_cliente_comuna"})
     */
    protected $comuna;

    
    /**
     * @ORM\OneToMany(targetEntity="RutaDetalle", mappedBy="cliente", cascade={"persist", "remove"} )
     */
    protected  $rutas;


    /**
     * @ORM\OneToMany(targetEntity="ProcesoClientes", mappedBy="cliente")
     */
    protected $procesoClientes;
    
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
     * Set cliNombre
     *
     * @param string $cliNombre
     *
     * @return Cliente
     */
    public function setCliNombre($cliNombre)
    {
        $this->cliNombre = $cliNombre;

        return $this;
    }

    /**
     * Get cliNombre
     *
     * @return string
     */
    public function getCliNombre()
    {
        return $this->cliNombre;
    }

    /**
     * Set cliDireccion
     *
     * @param string $cliDireccion
     *
     * @return Cliente
     */
    public function setCliDireccion($cliDireccion)
    {
        if($cliDireccion){
            $this->cliDireccion = $cliDireccion;
        }

        return $this;
    }

    /**
     * Get cliDireccion
     *
     * @return string
     */
    public function getCliDireccion()
    {
        return $this->cliDireccion;
    }

    /**
     * Set cliTelefono
     *
     * @param string $cliTelefono
     *
     * @return Cliente
     */
    public function setCliTelefono($cliTelefono)
    {
        if($cliTelefono) {
            $this->cliTelefono = $cliTelefono;
        }
        return $this;
    }

    /**
     * Get cliTelefono
     *
     * @return string
     */
    public function getCliTelefono()
    {
        return $this->cliTelefono;
    }

    /**
     * Set cliCelular
     *
     * @param string $cliCelular
     *
     * @return Cliente
     */
    public function setCliCelular($cliCelular)
    {
        if($cliCelular) {
            $this->cliCelular = $cliCelular;
        }
        return $this;
    }

    /**
     * Get cliCelular
     *
     * @return string
     */
    public function getCliCelular()
    {
        return $this->cliCelular;
    }

    /**
     * Set cliCorreo
     *
     * @param string $cliCorreo
     *
     * @return Cliente
     */
    public function setCliCorreo($cliCorreo)
    {
        if($cliCorreo) {
            $this->cliCorreo = $cliCorreo;
        }

        return $this;
    }

    /**
     * Get cliCorreo
     *
     * @return string
     */
    public function getCliCorreo()
    {
        return $this->cliCorreo;
    }

    /**
     * Set cliVisible
     *
     * @param boolean $cliVisible
     *
     * @return Cliente
     */
    public function setCliVisible($cliVisible)
    {
        $this->cliVisible = $cliVisible;

        return $this;
    }

    /**
     * Get cliVisible
     *
     * @return bool
     */
    public function getCliVisible()
    {
        return $this->cliVisible;
    }

    /**
     * Set cliLongitud
     *
     * @param integer $cliLongitud
     *
     * @return Cliente
     */
    public function setCliLongitud($cliLongitud)
    {
        $this->cliLongitud = $cliLongitud;

        return $this;
    }

    /**
     * Get cliLongitud
     *
     * @return int
     */
    public function getCliLongitud()
    {
        return $this->cliLongitud;
    }

    /**
     * Set cliLatitud
     *
     * @param integer $cliLatitud
     *
     * @return Cliente
     */
    public function setCliLatitud($cliLatitud)
    {
        $this->cliLatitud = $cliLatitud;

        return $this;
    }

    /**
     * Get cliLatitud
     *
     * @return int
     */
    public function getCliLatitud()
    {
        return $this->cliLatitud;
    }

    /**
     * Set frecuencia
     *
     * @param \AppBundle\Entity\Frecuencia $frecuencia
     *
     * @return Cliente
     */
    public function setFrecuencia(\AppBundle\Entity\Frecuencia $frecuencia = null)
    {
        if($frecuencia) {
            $this->frecuencia = $frecuencia;
        }

        return $this;
    }

    /**
     * Get frecuencia
     *
     * @return \AppBundle\Entity\Frecuencia
     */
    public function getFrecuencia()
    {
        return $this->frecuencia;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Cliente
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
     * Set comuna
     *
     * @param \AppBundle\Entity\Comuna $comuna
     *
     * @return Cliente
     */
    public function setComuna(\AppBundle\Entity\Comuna $comuna = null)
    {
        if($comuna) {
            $this->comuna = $comuna;
        }
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
     * Set cliDemanda
     *
     * @param integer $cliDemanda
     *
     * @return Cliente
     */
    public function setCliDemanda($cliDemanda)
    {
        if($cliDemanda) {
            $this->cliDemanda = $cliDemanda;
        }
        return $this;
    }

    /**
     * Get cliDemanda
     *
     * @return integer
     */
    public function getCliDemanda()
    {
        return $this->cliDemanda;
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
     * @param \AppBundle\Entity\RutaDetalle $ruta
     *
     * @return Cliente
     */
    public function addRuta(\AppBundle\Entity\RutaDetalle $ruta)
    {
        $this->rutas[] = $ruta;

        return $this;
    }

    /**
     * Remove ruta
     *
     * @param \AppBundle\Entity\RutaDetalle $ruta
     */
    public function removeRuta(\AppBundle\Entity\RutaDetalle $ruta)
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
     * Set usuario
     *
     * @param \AppBundle\Entity\User $usuario
     *
     * @return Cliente
     */
    public function setUsuario(\AppBundle\Entity\User $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set cliTheta
     *
     * @param string $cliTheta
     *
     * @return Cliente
     */
    public function setCliTheta($cliTheta)
    {
        $this->cliTheta = $cliTheta;

        return $this;
    }

    /**
     * Get cliTheta
     *
     * @return string
     */
    public function getCliTheta()
    {
        return $this->cliTheta;
    }

    /**
     * Add procesoCliente
     *
     * @param \AppBundle\Entity\ProcesoClientes $procesoCliente
     *
     * @return Cliente
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
}
