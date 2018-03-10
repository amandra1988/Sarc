<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * ProcesoClientes
 *
 * @ORM\Table(name="proceso_clientes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesoClientesRepository")
 */
class ProcesoClientes
{
    /**
     * @var int
     *
     * @ORM\Column(name="pcl_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Proceso", inversedBy="procesoClientes")
     * @ORM\JoinColumn(name="prc_id", referencedColumnName="prc_id")
     */
    private $proceso;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="procesoClientes")
     * @ORM\JoinColumn(name="cli_id", referencedColumnName="cli_id")
     */
    private $cliente;

    /**
     * @var int
     *
     * @ORM\Column(name="pcl_orden", type="integer")
     */
    private $pclOrden;


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
     * Set cliId
     *
     * @param integer $cliId
     *
     * @return ProcesoClientes
     */
    public function setCliId($cliId)
    {
        $this->cliId = $cliId;

        return $this;
    }

    /**
     * Get cliId
     *
     * @return int
     */
    public function getCliId()
    {
        return $this->cliId;
    }

    /**
     * Set pclOrden
     *
     * @param integer $pclOrden
     *
     * @return ProcesoClientes
     */
    public function setPclOrden($pclOrden)
    {
        $this->pclOrden = $pclOrden;

        return $this;
    }

    /**
     * Get pclOrden
     *
     * @return int
     */
    public function getPclOrden()
    {
        return $this->pclOrden;
    }

    /**
     * Set proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     *
     * @return ProcesoClientes
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
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return ProcesoClientes
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}
