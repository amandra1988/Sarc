<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Comuna
 *
 * @ORM\Table(name="comuna")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComunaRepository")
 */
class Comuna
{
    /**
     * @var int
     *
     * @ORM\Column(name="com_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("comuna_id")
     * @JMS\Groups({"comuna_detalle","comuna_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="com_nombre", type="string", length=120)
     * @JMS\SerializedName("comuna_nombre")
     * @JMS\Groups({"comuna_detalle","comuna_lista"})
     */
    private $comNombre;
  
    /**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="comunas" )
     * @ORM\JoinColumn(name="prv_id", referencedColumnName="prv_id")
     * @JMS\SerializedName("provincia")
     * @JMS\Groups({"r_comuna_provincia"})
     */
    protected $provincia;
    
    /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="comuna", cascade={"persist", "remove"} )
     */
    protected  $clientes;
    
     /**
     * @ORM\OneToMany(targetEntity="CentroDeAcopio", mappedBy="comuna", cascade={"persist", "remove"} )
     */
    protected  $centrosDeAcopio;
    
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
     * Set comNombre
     *
     * @param string $comNombre
     *
     * @return Comuna
     */
    public function setComNombre($comNombre)
    {
        $this->comNombre = $comNombre;

        return $this;
    }

    /**
     * Get comNombre
     *
     * @return string
     */
    public function getComNombre()
    {
        return $this->comNombre;
    }

    /**
     * Set provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Comuna
     */
    public function setProvincia(\AppBundle\Entity\Provincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \AppBundle\Entity\Provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->centrosDeAcopio = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Comuna
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
     * Add centrosDeAcopio
     *
     * @param \AppBundle\Entity\CentroDeAcopio $centrosDeAcopio
     *
     * @return Comuna
     */
    public function addCentrosDeAcopio(\AppBundle\Entity\CentroDeAcopio $centrosDeAcopio)
    {
        $this->centrosDeAcopio[] = $centrosDeAcopio;

        return $this;
    }

    /**
     * Remove centrosDeAcopio
     *
     * @param \AppBundle\Entity\CentroDeAcopio $centrosDeAcopio
     */
    public function removeCentrosDeAcopio(\AppBundle\Entity\CentroDeAcopio $centrosDeAcopio)
    {
        $this->centrosDeAcopio->removeElement($centrosDeAcopio);
    }

    /**
     * Get centrosDeAcopio
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCentrosDeAcopio()
    {
        return $this->centrosDeAcopio;
    }
}
