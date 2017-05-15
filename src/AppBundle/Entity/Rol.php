<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Rol
 *
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RolRepository")
 */
class Rol
{
    /**
     * @var int
     *
     * @ORM\Column(name="rol_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("rol_id")
     * @JMS\Groups({"rol_detalle","rol_lista"})
     */
    private $id;
    
    /**
     * @ORM\Column(name="rol_nombre", type="string", length=25, unique=true)
     * @JMS\SerializedName("rol_nombre")
     * @JMS\Groups({"rol_detalle","rol_lista"})
     */
    private $nombre;
    
    
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="rol", cascade={"persist", "remove"} )
     */
    protected  $usuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Rol
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
     * Add usuario
     *
     * @param \AppBundle\Entity\User $usuario
     *
     * @return Rol
     */
    public function addUsuario(\AppBundle\Entity\User $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \AppBundle\Entity\User $usuario
     */
    public function removeUsuario(\AppBundle\Entity\User $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
