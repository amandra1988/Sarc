<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoRepository")
 */
class Resultado
{
    /**
     * @var int
     *
     * @ORM\Column(name="res_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Proceso", inversedBy="resultados" )
     * @ORM\JoinColumn(name="prc_id", referencedColumnName="prc_id")
    */
    protected $proceso;

    /**
     * @var int
     *
     * @ORM\Column(name="res_dia", type="integer")
     */
    private $resDia;


    /**
    * @ORM\ManyToOne(targetEntity="Camion", inversedBy="resultados" )
    * @ORM\JoinColumn(name="cam_id", referencedColumnName="cam_id")
    */
    protected $camion;

    /**
    * @var string
    *
    * @ORM\Column(name="res_clientes", type="string")
    */
    private $resClientes;


    /**
     * @var string
     *
     * @ORM\Column(name="res_total_demanda", type="string")
     */
    private $resTotalDemanda;


    /**
     * @var string
     *
     * @ORM\Column(name="res_total_capacidad", type="string")
     */
    private $resTotalCapacidad;

    /**
     * @var int
     *
     * @ORM\Column(name="res_total_clientes", type="integer")
     */
    private $resTotalClientes;
    

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
     * Set resDia
     *
     * @param integer $resDia
     *
     * @return Resultado
     */
    public function setResDia($resDia)
    {
        $this->resDia = $resDia;

        return $this;
    }

    /**
     * Get resDia
     *
     * @return integer
     */
    public function getResDia()
    {
        return $this->resDia;
    }

    /**
     * Set resClientes
     *
     * @param string $resClientes
     *
     * @return Resultado
     */
    public function setResClientes($resClientes)
    {
        $this->resClientes = $resClientes;

        return $this;
    }

    /**
     * Get resClientes
     *
     * @return string
     */
    public function getResClientes()
    {
        return $this->resClientes;
    }

    /**
     * Set resTotalDemanda
     *
     * @param string $resTotalDemanda
     *
     * @return Resultado
     */
    public function setResTotalDemanda($resTotalDemanda)
    {
        $this->resTotalDemanda = $resTotalDemanda;

        return $this;
    }

    /**
     * Get resTotalDemanda
     *
     * @return string
     */
    public function getResTotalDemanda()
    {
        return $this->resTotalDemanda;
    }

    /**
     * Set resTotalCapacidad
     *
     * @param string $resTotalCapacidad
     *
     * @return Resultado
     */
    public function setResTotalCapacidad($resTotalCapacidad)
    {
        $this->resTotalCapacidad = $resTotalCapacidad;

        return $this;
    }

    /**
     * Get resTotalCapacidad
     *
     * @return string
     */
    public function getResTotalCapacidad()
    {
        return $this->resTotalCapacidad;
    }

    /**
     * Set proceso
     *
     * @param \AppBundle\Entity\Proceso $proceso
     *
     * @return Resultado
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
     * @return Resultado
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

    /**
     * Set resTotalClientes
     *
     * @param integer $resTotalClientes
     *
     * @return Resultado
     */
    public function setResTotalClientes($resTotalClientes)
    {
        $this->resTotalClientes = $resTotalClientes;

        return $this;
    }

    /**
     * Get resTotalClientes
     *
     * @return integer
     */
    public function getResTotalClientes()
    {
        return $this->resTotalClientes;
    }
}
