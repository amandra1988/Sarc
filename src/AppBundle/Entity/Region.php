<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegionRepository")
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="reg_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("region_id")
     * @JMS\Groups({"region_detalle","region_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_nombre", type="string", length=120)
     * @JMS\SerializedName("region_nombre")
     * @JMS\Groups({"region_detalle","region_lista"})
     */
    private $regNombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reg_ordinal", type="string", length=5)
     */
    private $regOrdinal;


    /**
     * @ORM\OneToMany(targetEntity="Proceso", mappedBy="region", cascade={"persist", "remove"} )
     */
    protected  $procesos;

        
    /**
     * @ORM\OneToMany(targetEntity="Provincia", mappedBy="region", cascade={"persist", "remove"} )
     */
    protected  $provincias;


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
     * Set regNombre
     *
     * @param string $regNombre
     *
     * @return Region
     */
    public function setRegNombre($regNombre)
    {
        $this->regNombre = $regNombre;

        return $this;
    }

    /**
     * Get regNombre
     *
     * @return string
     */
    public function getRegNombre()
    {
        return $this->regNombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provincias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     *
     * @return Region
     */
    public function addProvincia(\AppBundle\Entity\Provincia $provincia)
    {
        $this->provincias[] = $provincia;

        return $this;
    }

    /**
     * Remove provincia
     *
     * @param \AppBundle\Entity\Provincia $provincia
     */
    public function removeProvincia(\AppBundle\Entity\Provincia $provincia)
    {
        $this->provincias->removeElement($provincia);
    }

    /**
     * Get provincias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvincias()
    {
        return $this->provincias;
    }

    /**
     * Set regOrdinal
     *
     * @param string $regOrdinal
     *
     * @return Region
     */
    public function setRegOrdinal($regOrdinal)
    {
        $this->regOrdinal = $regOrdinal;

        return $this;
    }

    /**
     * Get regOrdinal
     *
     * @return string
     */
    public function getRegOrdinal()
    {
        return $this->regOrdinal;
    }

    /**
     * Add proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     *
     * @return Region
     */
    public function addProceso(\AppBundle\Entity\Proceso $proceso)
    {
        $this->procesos[] = $proceso;

        return $this;
    }

    /**
     * Remove proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     */
    public function removeProceso(\AppBundle\Entity\Proceso $proceso)
    {
        $this->procesos->removeElement($proceso);
    }

    /**
     * Get procesos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProcesos()
    {
        return $this->procesos;
    }
}
