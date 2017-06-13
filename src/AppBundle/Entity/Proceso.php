<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proceso
 *
 * @ORM\Table(name="proceso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProcesoRepository")
 */
class Proceso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="algo", type="string", length=255, nullable=true)
     */
    private $algo;


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
     * Set algo
     *
     * @param string $algo
     *
     * @return Proceso
     */
    public function setAlgo($algo)
    {
        $this->algo = $algo;

        return $this;
    }

    /**
     * Get algo
     *
     * @return string
     */
    public function getAlgo()
    {
        return $this->algo;
    }
}

