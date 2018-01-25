<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfiguracionAmpl
 *
 * @ORM\Table(name="configuracion_ampl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfiguracionAmplRepository")
 */
class ConfiguracionAmpl
{
    /**
     * @var int
     *
     * @ORM\Column(name="cnf_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="cnf_dias", type="integer")
     */
    private $dias;

    /**
     * @var int
     *
     * @ORM\Column(name="cnf_infinito", type="integer")
     */
    private $infinito;

    /**
     * @var int
     *
     * @ORM\Column(name="cnf_epsilon", type="integer")
     */
    private $epsilon;

    /**
     * @var int
     *
     * @ORM\Column(name="cnf_epcilo_dos", type="integer")
     */
    private $epciloDos;


    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Empresa", inversedBy="configuracionAmpl")
     * @ORM\JoinColumn(name="emp_id", referencedColumnName="emp_id")
     */
    private $empresa;

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
     * Set dias
     *
     * @param integer $dias
     *
     * @return ConfiguracionAmpl
     */
    public function setDias($dias)
    {
        $this->dias = $dias;

        return $this;
    }

    /**
     * Get dias
     *
     * @return int
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set infinito
     *
     * @param integer $infinito
     *
     * @return ConfiguracionAmpl
     */
    public function setInfinito($infinito)
    {
        $this->infinito = $infinito;

        return $this;
    }

    /**
     * Get infinito
     *
     * @return int
     */
    public function getInfinito()
    {
        return $this->infinito;
    }

    /**
     * Set epsilon
     *
     * @param integer $epsilon
     *
     * @return ConfiguracionAmpl
     */
    public function setEpsilon($epsilon)
    {
        $this->epsilon = $epsilon;

        return $this;
    }

    /**
     * Get epsilon
     *
     * @return int
     */
    public function getEpsilon()
    {
        return $this->epsilon;
    }

    /**
     * Set epciloDos
     *
     * @param integer $epciloDos
     *
     * @return ConfiguracionAmpl
     */
    public function setEpciloDos($epciloDos)
    {
        $this->epciloDos = $epciloDos;

        return $this;
    }

    /**
     * Get epciloDos
     *
     * @return int
     */
    public function getEpciloDos()
    {
        return $this->epciloDos;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return ConfiguracionAmpl
     */
    public function setEmpresa(\AppBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
