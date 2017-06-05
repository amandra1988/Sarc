<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Frecuencia
 *
 * @ORM\Table(name="frecuencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FrecuenciaRepository")
 */
class Frecuencia
{
    /**
     * @var int
     *
     * @ORM\Column(name="fre_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("frecuencia_id")
     * @JMS\Groups({"frecuencia_detalle","frecuencia_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @JMS\SerializedName("frecuencia_nombre")
     * @JMS\Groups({"frecuencia_detalle","frecuencia_lista"})
     */
    private $nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="frecuencia", cascade={"persist", "remove"} )
     */
    protected  $clientes;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Frecuencia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cliente
     *
     * @param \AppBundle\Entity\Frecuencia $cliente
     *
     * @return Frecuencia
     */
    public function addCliente(\AppBundle\Entity\Frecuencia $cliente)
    {
        $this->clientes[] = $cliente;

        return $this;
    }

    /**
     * Remove cliente
     *
     * @param \AppBundle\Entity\Frecuencia $cliente
     */
    public function removeCliente(\AppBundle\Entity\Frecuencia $cliente)
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
}
