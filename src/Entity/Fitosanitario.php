<?php

namespace App\Entity;

use App\Repository\FitosanitarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FitosanitarioRepository::class)
 */
class Fitosanitario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecdetpat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fordet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metdet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fitpat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $patdet;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $obs;

    /**
     * @ORM\ManyToOne(targetEntity=Variedad::class, inversedBy="fitosanitarios")
     */
    private $variedad;

    /**
     * @ORM\ManyToOne(targetEntity=Envase::class, inversedBy="fitosanitarios")
     */
    private $envase;

    /**
     * @ORM\ManyToOne(targetEntity=Entrada::class, inversedBy="fitosanitarios")
     */
    private $entrada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecdetpat(): ?\DateTimeInterface
    {
        return $this->fecdetpat;
    }

    public function setFecdetpat(?\DateTimeInterface $fecdetpat): self
    {
        $this->fecdetpat = $fecdetpat;

        return $this;
    }

    public function getFordet(): ?string
    {
        return $this->fordet;
    }

    public function setFordet(?string $fordet): self
    {
        $this->fordet = $fordet;

        return $this;
    }

    public function getMetdet(): ?string
    {
        return $this->metdet;
    }

    public function setMetdet(?string $metdet): self
    {
        $this->metdet = $metdet;

        return $this;
    }

    public function getFitpat(): ?string
    {
        return $this->fitpat;
    }

    public function setFitpat(?string $fitpat): self
    {
        $this->fitpat = $fitpat;

        return $this;
    }

    public function getPatdet(): ?string
    {
        return $this->patdet;
    }

    public function setPatdet(?string $patdet): self
    {
        $this->patdet = $patdet;

        return $this;
    }

    public function getObs(): ?string
    {
        return $this->obs;
    }

    public function setObs(?string $obs): self
    {
        $this->obs = $obs;

        return $this;
    }

    public function getVariedad(): ?Variedad
    {
        return $this->variedad;
    }

    public function setVariedad(?Variedad $variedad): self
    {
        $this->variedad = $variedad;

        return $this;
    }

    public function getEnvase(): ?Envase
    {
        return $this->envase;
    }

    public function setEnvase(?Envase $envase): self
    {
        $this->envase = $envase;

        return $this;
    }

    public function getEntrada(): ?Entrada
    {
        return $this->entrada;
    }

    public function setEntrada(?Entrada $entrada): self
    {
        $this->entrada = $entrada;

        return $this;
    }
}
