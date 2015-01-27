<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidades
 *
 * @ORM\Table(name="cidades", indexes={@ORM\Index(name="fk_estado_id", columns={"estado_id"})})
 * @ORM\Entity
 */
class Cidades
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
     * @var integer
     *
     * @ORM\Column(name="codigo_ibge", type="integer", nullable=true)
     */
    private $codigoIbge;

    /**
     * @var integer
     *
     * @ORM\Column(name="populacao_2010", type="integer", nullable=true)
     */
    private $populacao2010;

    /**
     * @var string
     *
     * @ORM\Column(name="densidade_demo", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $densidadeDemo;

    /**
     * @var string
     *
     * @ORM\Column(name="gentilico", type="string", length=250, nullable=true)
     */
    private $gentilico;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="decimal", precision=10, scale=3, nullable=true)
     */
    private $area;

    /**
     * @var \Application\Entity\Estados
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Estados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     * })
     */
    private $estado;



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
     * @return Cidades
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
     * Set codigoIbge
     *
     * @param integer $codigoIbge
     * @return Cidades
     */
    public function setCodigoIbge($codigoIbge)
    {
        $this->codigoIbge = $codigoIbge;

        return $this;
    }

    /**
     * Get codigoIbge
     *
     * @return integer 
     */
    public function getCodigoIbge()
    {
        return $this->codigoIbge;
    }

    /**
     * Set populacao2010
     *
     * @param integer $populacao2010
     * @return Cidades
     */
    public function setPopulacao2010($populacao2010)
    {
        $this->populacao2010 = $populacao2010;

        return $this;
    }

    /**
     * Get populacao2010
     *
     * @return integer 
     */
    public function getPopulacao2010()
    {
        return $this->populacao2010;
    }

    /**
     * Set densidadeDemo
     *
     * @param string $densidadeDemo
     * @return Cidades
     */
    public function setDensidadeDemo($densidadeDemo)
    {
        $this->densidadeDemo = $densidadeDemo;

        return $this;
    }

    /**
     * Get densidadeDemo
     *
     * @return string 
     */
    public function getDensidadeDemo()
    {
        return $this->densidadeDemo;
    }

    /**
     * Set gentilico
     *
     * @param string $gentilico
     * @return Cidades
     */
    public function setGentilico($gentilico)
    {
        $this->gentilico = $gentilico;

        return $this;
    }

    /**
     * Get gentilico
     *
     * @return string 
     */
    public function getGentilico()
    {
        return $this->gentilico;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return Cidades
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set estado
     *
     * @param \Application\Entity\Estados $estado
     * @return Cidades
     */
    public function setEstado(\Application\Entity\Estados $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Application\Entity\Estados 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
