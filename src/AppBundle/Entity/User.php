<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
*/
class User implements UserInterface, \Serializable
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @JMS\SerializedName("id")
    * @JMS\Groups({"usuario_detalle","usuario_lista"})
    */
    private $id;

    /**
    * @ORM\Column(name="username", type="string", length=25, unique=true)
    * @JMS\SerializedName("username")
    * @JMS\Groups({"usuario_detalle","usuario_lista"})
    */
    private $username;

    /**
    * @ORM\Column(name="password", type="string", length=64)
    */
    private $password;
    
    /**
    * @ORM\Column(name="usr_visible", type="boolean", options={"default":1})
    */
    private $visible;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="usuario" )
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="rol_id")
     * @JMS\SerializedName("rol")
     * @JMS\Groups({"r_usuario_rol"})
     */
    protected $rol;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="usuarios" )
     * @ORM\JoinColumn(name="emp_id", referencedColumnName="emp_id")
     * @JMS\SerializedName("empresa")
     * @JMS\Groups({"r_usuario_empresa"})
     */
    protected $empresa;
    
    /**
     * @ORM\OneToOne(targetEntity="Operador", mappedBy="usuario", cascade={"persist", "remove"} )
     */
    protected  $operadores;
    

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $token;

    public function __construct()
    {
        $this->visible = true;
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->getRol()->getNombre());
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return User
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set rol
     *
     * @param \AppBundle\Entity\Rol $rol
     *
     * @return User
     */
    public function setRol(\AppBundle\Entity\Rol $rol = null)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\Empresa $empresa
     *
     * @return Usuario
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

    /**
     * Add operadore
     *
     * @param \AppBundle\Entity\Operador $operadore
     *
     * @return User
     */
    public function addOperadore(\AppBundle\Entity\Operador $operadore)
    {
        $this->operadores[] = $operadore;

        return $this;
    }

    /**
     * Remove operadore
     *
     * @param \AppBundle\Entity\Operador $operadore
     */
    public function removeOperadore(\AppBundle\Entity\Operador $operadore)
    {
        $this->operadores->removeElement($operadore);
    }

    /**
     * Get operadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperadores()
    {
        return $this->operadores;
    }
}
