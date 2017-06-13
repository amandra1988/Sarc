<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
{
    /**
     * @var int
     *
     * @ORM\Column(name="emp_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="emp_nombre", type="string", length=255)
     * @JMS\SerializedName("nombre_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $empNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="emp_rut", type="string", length=15)
     * @JMS\SerializedName("rut_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $empRut;

    /**
     * @var string
     *
     * @ORM\Column(name="emp_direccion", type="string", length=255)
     * @JMS\SerializedName("direccion_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $empDireccion;

    /**
     * @var int
     *
     * @ORM\Column(name="emp_telefono", type="integer", length=9, nullable=true)
     * @JMS\SerializedName("telefono_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $empTelefono;

    /**
     * @var int
     *
     * @ORM\Column(name="emp_celular", type="integer", length=9, nullable=true)
     * @JMS\SerializedName("celular_empresa")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    private $empCelular;

    /**
     * @var bool
     *
     * @ORM\Column(name="emp_visible", type="boolean")
     */
    private $empVisible;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="empresa", cascade={"persist", "remove"} )
     */
    protected  $usuarios;

     /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="empresa", cascade={"persist", "remove"} )
     */
    protected  $clientes;
    
    /**
     * @ORM\OneToMany(targetEntity="Camion", mappedBy="empresa", cascade={"persist", "remove"} )
     */
    protected  $camiones;
    
    /**
     * @ORM\ManyToOne(targetEntity="CentroDeAcopio", inversedBy="empresas" )
     * @ORM\JoinColumn(name="cen_id", referencedColumnName="cen_id")
     * @JMS\SerializedName("centro_de_acopio")
     * @JMS\Groups({"empresa_detalle","empresa_lista"})
     */
    protected $centroDeAcopio;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set empNombre
     *
     * @param string $empNombre
     *
     * @return Empresa
     */
    public function setEmpNombre($empNombre)
    {
        if($empNombre){
           $this->empNombre = $empNombre;
        }
        return $this;
    }

    /**
     * Get empNombre
     *
     * @return string
     */
    public function getEmpNombre()
    {
        return $this->empNombre;
    }

    /**
     * Set empRut
     *
     * @param string $empRut
     *
     * @return Empresa
     */
    public function setEmpRut($empRut)
    {
        if($empRut){
            $this->empRut = $empRut;
        }
        return $this;
    }

    /**
     * Get empRut
     *
     * @return string
     */
    public function getEmpRut()
    {
        return $this->empRut;
    }

    /**
     * Set empDireccion
     *
     * @param string $empDireccion
     *
     * @return Empresa
     */
    public function setEmpDireccion($empDireccion)
    {
        if($empDireccion){
            $this->empDireccion = $empDireccion;
        }
        return $this;
    }

    /**
     * Get empDireccion
     *
     * @return string
     */
    public function getEmpDireccion()
    {
        return $this->empDireccion;
    }

    /**
     * Set empTelefono
     *
     * @param string $empTelefono
     *
     * @return Empresa
     */
    public function setEmpTelefono($empTelefono)
    {
        if($empTelefono){
            $this->empTelefono = $empTelefono;
        }
        return $this;
    }

    /**
     * Get empTelefono
     *
     * @return string
     */
    public function getEmpTelefono()
    {
        return $this->empTelefono;
    }

    /**
     * Set empCelular
     *
     * @param string $empCelular
     *
     * @return Empresa
     */
    public function setEmpCelular($empCelular)
    {
        if($empCelular){
            $this->empCelular = $empCelular;
        }
        return $this;
    }

    /**
     * Get empCelular
     *
     * @return string
     */
    public function getEmpCelular()
    {
        return $this->empCelular;
    }

    /**
     * Set empVisible
     *
     * @param boolean $empVisible
     *
     * @return Empresa
     */
    public function setEmpVisible($empVisible)
    {
        $this->empVisible = $empVisible;

        return $this;
    }

    /**
     * Get empVisible
     *
     * @return boolean
     */
    public function getEmpVisible()
    {
        return $this->empVisible;
    }

    /**
     * Add usuario
     *
     * @param \AppBundle\Entity\User $usuario
     *
     * @return Empresa
     */
    public function addUsuario(\AppBundle\Entity\User $usuario)
    {
        $this->usuarios[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \AppBundle\Entity\User $usuario
     */
    public function removeUsuario(\AppBundle\Entity\User $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Add cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Empresa
     */
    public function addCliente(\AppBundle\Entity\Cliente $cliente)
    {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     */
    public function removeCliente(\AppBundle\Entity\Cliente $cliente)
    {
        $this->clientes->removeElement($cliente);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
        return $this->clientes;
    }

    /**
     * Set centroDeAcopio
     *
     * @param \AppBundle\Entity\CentroDeAcopio $centroDeAcopio
     *
     * @return Empresa
     */
    public function setCentroDeAcopio(\AppBundle\Entity\CentroDeAcopio $centroDeAcopio = null)
    {
        $this->centroDeAcopio = $centroDeAcopio;

        return $this;
    }

    /**
     * Get centroDeAcopio
     *
     * @return \AppBundle\Entity\CentroDeAcopio
     */
    public function getCentroDeAcopio()
    {
        return $this->centroDeAcopio;
    }

    /**
     * Add camione
     *
     * @param \AppBundle\Entity\Camion $camione
     *
     * @return Empresa
     */
    public function addCamione(\AppBundle\Entity\Camion $camione)
    {
        $this->camiones[] = $camione;

        return $this;
    }

    /**
     * Remove camione
     *
     * @param \AppBundle\Entity\Camion $camione
     */
    public function removeCamione(\AppBundle\Entity\Camion $camione)
    {
        $this->camiones->removeElement($camione);
    }

    /**
     * Get camiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCamiones()
    {
        return $this->camiones;
    }
}
