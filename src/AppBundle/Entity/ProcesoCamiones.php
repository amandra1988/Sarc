<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesoCamiones
 *
 * @ORM\Table(name="proceso_camiones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesoCamionesRepository")
 */
class ProcesoCamiones
{
    /**
     * @var int
     *
     * @ORM\Column(name="pcm_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Proceso", inversedBy="procesoCamiones")
     * @ORM\JoinColumn(name="prc_id", referencedColumnName="prc_id")
     */
    private $proceso;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Camion", inversedBy="procesoCamiones")
     * @ORM\JoinColumn(name="cam_id", referencedColumnName="cam_id")
     */
    private $camion;


    /**
     * @var int
     *
     * @ORM\Column(name="pcm_orden", type="integer")
     */
    private $pcmOrden;


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
     * Set procesoId
     *
     * @param integer $procesoId
     *
     * @return ProcesoCamiones
     */
    public function setProcesoId($procesoId)
    {
        $this->procesoId = $procesoId;

        return $this;
    }

    /**
     * Get procesoId
     *
     * @return int
     */
    public function getProcesoId()
    {
        return $this->procesoId;
    }

    /**
     * Set camionId
     *
     * @param integer $camionId
     *
     * @return ProcesoCamiones
     */
    public function setCamionId($camionId)
    {
        $this->camionId = $camionId;

        return $this;
    }

    /**
     * Get camionId
     *
     * @return int
     */
    public function getCamionId()
    {
        return $this->camionId;
    }

    /**
     * Set pcmOrden
     *
     * @param integer $pcmOrden
     *
     * @return ProcesoCamiones
     */
    public function setPcmOrden($pcmOrden)
    {
        $this->pcmOrden = $pcmOrden;

        return $this;
    }

    /**
     * Get pcmOrden
     *
     * @return int
     */
    public function getPcmOrden()
    {
        return $this->pcmOrden;
    }

    /**
     * Set proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     *
     * @return ProcesoCamiones
     */
    public function setProceso(\AppBundle\Entity\Proceso $proceso = null)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso
     *
     * @return \AppBundle\Entity\Proceso
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Set camion
     *
     * @param \AppBundle\Entity\Camion $camion
     *
     * @return ProcesoCamiones
     */
    public function setCamion(\AppBundle\Entity\Camion $camion = null)
    {
        $this->camion = $camion;

        return $this;
    }

    /**
     * Get camion
     *
     * @return \AppBundle\Entity\Camion
     */
    public function getCamion()
    {
        return $this->camion;
    }
}
