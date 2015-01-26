<?php
namespace Application\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\Stdlib\Hydrator;


/**
 * User
 *
 * @ODM\Document(
 *     collection="User"
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class User {

    /**
     * @ODM\Id
     * @ODM\Index
     */
    protected $id;

    /**
     * @ODM\Field(type="date")
     */
    protected $criadoEm;


    /**
     *
     * @ODM\Field(type="string")
     */
    protected $nome;

    /**
     *
     * @ODM\Field(type="string")
     */
    protected $senha;

    /**
     *
     * @ODM\Field(type="string")
     */
    protected $login;

    public function __toString() {
        return $this->id ? (string)$this->id : '';
    }

    /**
     * @ODM\PreFlush
     */
    public function preFlush()
    {
        ($this->criadoEm)? null :$this->criadoEm = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriadoEm()
    {
        return $this->criadoEm;
    }

    /**
     * @param mixed $criadoEm
     */
    public function setCriadoEm($criadoEm)
    {
        $this->criadoEm = $criadoEm;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }




}