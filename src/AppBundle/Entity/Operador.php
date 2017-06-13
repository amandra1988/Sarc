<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Operador
 *
 * @ORM\Table(name="operador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperadorRepository")
 */
class Operador
{
    /**
     * @var int
     *
     * @ORM\Column(name="ope_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id_operador")
     * @JMS\Groups({"operador_detalle","operador_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ope_nombre", type="string", length=255)
     * @JMS\SerializedName("nombre_operador")
     * @JMS\Groups({"operador_detalle","operador_lista"})
     */
    private $opeNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="ope_apellido", type="string", length=255)
     * @JMS\SerializedName("apellido_operador")
     * @JMS\Groups({"operador_detalle","operador_lista"})
     */
    private $opeApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="ope_rut", type="string", length=255)
     * @JMS\SerializedName("rut_operador")
     * @JMS\Groups({"operador_lista"})
     */
    private $opeRut;

    /**
     * @var string
     *
     * @ORM\Column(name="ope_licencia", type="string", length=50)
     * @JMS\SerializedName("licencia_operador")
     * @JMS\Groups({"operador_lista"})
     */
    private $opeLicencia;

    /**
     * @var int
     *
     * @ORM\Column(name="ope_celular", type="integer", length=9, nullable=true)
     * @JMS\SerializedName("celular_operador")
     * @JMS\Groups({"operador_lista"})
     */
    private $opeCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="ope_correo", type="string", length=255, nullable=true)
     * @JMS\SerializedName("correo_operador")
     * @JMS\Groups({"operador_lista"})
     */
    private $opeCorreo;

    /**
     * @var bool
     *
     * @ORM\Column(name="ope_visible", type="boolean")
     */
    private $opeVisible;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="operadores" )
     * @ORM\JoinColumn(name="usr_id", referencedColumnName="id")
     * @JMS\SerializedName("usuario")
     * @JMS\Groups({"r_operador_usuario"})
     */
    protected $usuario;


	/**
     * @ORM\OneToMany(targetEntity="Ruta", mappedBy="operador", cascade={"persist", "remove"} )
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
     * Set opeNombre
     *
     * @param string $opeNombre
     *
     * @return Operador
     */
    public function setOpeNombre($opeNombre)
    {
        if($opeNombre){
            $this->opeNombre = $opeNombre;
        }
        return $this;
    }

    /**
     * Get opeNombre
     *
     * @return string
     */
    public function getOpeNombre()
    {
        return $this->opeNombre;
    }

    /**
     * Set opeApellido
     *
     * @param string $opeApellido
     *
     * @return Operador
     */
    public function setOpeApellido($opeApellido)
    {
        if($opeApellido) {
            $this->opeApellido = $opeApellido;
        }
        return $this;
    }

    /**
     * Get opeApellido
     *
     * @return string
     */
    public function getOpeApellido()
    {
        return $this->opeApellido;
    }

    /**
     * Set opeRut
     *
     * @param string $opeRut
     *
     * @return Operador
     */
    public function setOpeRut($opeRut)
    {
        if($opeRut) {
            $this->opeRut = $opeRut;
        }

        return $this;
    }

    /**
     * Get opeRut
     *
     * @return string
     */
    public function getOpeRut()
    {
        return $this->opeRut;
    }

    /**
     * Set opeLicencia
     *
     * @param string $opeLicencia
     *
     * @return Operador
     */
    public function setOpeLicencia($opeLicencia)
    {
        if($opeLicencia) {
            $this->opeLicencia = $opeLicencia;
        }
        return $this;
    }

    /**
     * Get opeLicencia
     *
     * @return string
     */
    public function getOpeLicencia()
    {
        return $this->opeLicencia;
    }

    /**
     * Set opeCelular
     *
     * @param string $opeCelular
     *
     * @return Operador
     */
    public function setOpeCelular($opeCelular)
    {
        if($opeCelular) {
            $this->opeCelular = $opeCelular;
        }
        return $this;
    }

    /**
     * Get opeCelular
     *
     * @return string
     */
    public function getOpeCelular()
    {
        return $this->opeCelular;
    }

    /**
     * Set opeCorreo
     *
     * @param string $opeCorreo
     *
     * @return Operador
     */
    public function setOpeCorreo($opeCorreo)
    {
        if($opeCorreo) {
            $this->opeCorreo = $opeCorreo;
        }
        return $this;
    }

    /**
     * Get opeCorreo
     *
     * @return string
     */
    public function getOpeCorreo()
    {
        return $this->opeCorreo;
    }

    /**
     * Set opeVisible
     *
     * @param boolean $opeVisible
     *
     * @return Operador
     */
    public function setOpeVisible($opeVisible)
    {
        $this->opeVisible = $opeVisible;

        return $this;
    }

    /**
     * Get opeVisible
     *
     * @return bool
     */
    public function getOpeVisible()
    {
        return $this->opeVisible;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\User $usuario
     *
     * @return Operador
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
     * @return Operador
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
}
