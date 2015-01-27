<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estados
 *
 * @ORM\Table(name="estados")
 * @ORM\Entity
 */
class Estados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=250, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=250, nullable=true)
     */
    private $sigla;



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
     * Set nome
     *
     * @param string $nome
     * @return Estados
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Estados
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }
}
