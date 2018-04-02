<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theta
 *
 * @ORM\Table(name="theta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThetaRepository")
 */
class Theta
{
    /**
     * @var int
     *
     * @ORM\Column(name="tet_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tet_valor", type="string", length=25)
     */
    private $tetValor;

    /**
     * @var bool
     *
     * @ORM\Column(name="tet_ocupado", type="boolean")
     */
    private $tetOcupado;

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
     * Set tetValor
     *
     * @param string $tetValor
     *
     * @return Theta
     */
    public function setTetValor($tetValor)
    {
        $this->tetValor = $tetValor;

        return $this;
    }

    /**
     * Get tetValor
     *
     * @return string
     */
    public function getTetValor()
    {
        return $this->tetValor;
    }

    /**
     * Set tetOcupado
     *
     * @param boolean $tetOcupado
     *
     * @return Theta
     */
    public function setTetOcupado($tetOcupado)
    {
        $this->tetOcupado = $tetOcupado;

        return $this;
    }

    /**
     * Get tetOcupado
     *
     * @return boolean
     */
    public function getTetOcupado()
    {
        return $this->tetOcupado;
    }
}
