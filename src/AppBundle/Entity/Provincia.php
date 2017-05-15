<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Provincia
 *
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvinciaRepository")
 */
class Provincia
{
    /**
     * @var int
     *
     * @ORM\Column(name="prv_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("provincia_id")
     * @JMS\Groups({"provincia_detalle","provincia_lista"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prv_nombre", type="string", length=120)
     * @JMS\SerializedName("provincia_nombre")
     * @JMS\Groups({"provincia_detalle","provincia_lista"})
     */
    private $prvNombre;
      
    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="provincias" )
     * @ORM\JoinColumn(name="reg_id", referencedColumnName="reg_id")
     */
    protected $region;
    
    /**
     * @ORM\OneToMany(targetEntity="Comuna", mappedBy="provincia", cascade={"persist", "remove"} )
     */
    protected  $comunas;

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
     * Set prvNombre
     *
     * @param string $prvNombre
     *
     * @return Provincia
     */
    public function setPrvNombre($prvNombre)
    {
        $this->prvNombre = $prvNombre;

        return $this;
    }

    /**
     * Get prvNombre
     *
     * @return string
     */
    public function getPrvNombre()
    {
        return $this->prvNombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comunas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return Provincia
     */
    public function setRegion(\AppBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add comuna
     *
     * @param \AppBundle\Entity\Comuna $comuna
     *
     * @return Provincia
     */
    public function addComuna(\AppBundle\Entity\Comuna $comuna)
    {
        $this->comunas[] = $comuna;

        return $this;
    }

    /**
     * Remove comuna
     *
     * @param \AppBundle\Entity\Comuna $comuna
     */
    public function removeComuna(\AppBundle\Entity\Comuna $comuna)
    {
        $this->comunas->removeElement($comuna);
    }

    /**
     * Get comunas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComunas()
    {
        return $this->comunas;
    }
}
