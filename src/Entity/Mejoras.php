<?php

namespace App\Entity;

use App\Repository\MejorasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MejorasRepository::class)
 */
class Mejoras
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $metodoMejora;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $descripcionProcedimiento;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $imagenesProceso;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToMany(targetEntity=Instituciones::class, inversedBy="mejoras")
     */
    private $instituciones;

    /**
     * @ORM\ManyToMany(targetEntity=Persona::class, inversedBy="mejoras")
     */
    private $personas;

    /**
     * @ORM\OneToOne(targetEntity=Entrada::class, inversedBy="mejoras", cascade={"persist", "remove"})
     */
    private $entrada;

    public function __construct()
    {
        $this->instituciones = new ArrayCollection();
        $this->personas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetodoMejora(): ?string
    {
        return $this->metodoMejora;
    }

    public function setMetodoMejora(?string $metodoMejora): self
    {
        $this->metodoMejora = $metodoMejora;

        return $this;
    }

    public function getDescripcionProcedimiento(): ?string
    {
        return $this->descripcionProcedimiento;
    }

    public function setDescripcionProcedimiento(?string $descripcionProcedimiento): self
    {
        $this->descripcionProcedimiento = $descripcionProcedimiento;

        return $this;
    }

    public function getImagenesProceso(): ?string
    {
        return $this->imagenesProceso;
    }

    public function setImagenesProceso(?string $imagenesProceso): self
    {
        $this->imagenesProceso = $imagenesProceso;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * @return Collection|Instituciones[]
     */
    public function getInstituciones(): Collection
    {
        return $this->instituciones;
    }

    public function addInstitucione(Instituciones $institucione): self
    {
        if (!$this->instituciones->contains($institucione)) {
            $this->instituciones[] = $institucione;
        }

        return $this;
    }

    public function removeInstitucione(Instituciones $institucione): self
    {
        $this->instituciones->removeElement($institucione);

        return $this;
    }

    /**
     * @return Collection|Persona[]
     */
    public function getPersonas(): Collection
    {
        return $this->personas;
    }

    public function addPersona(Persona $persona): self
    {
        if (!$this->personas->contains($persona)) {
            $this->personas[] = $persona;
        }

        return $this;
    }

    public function removePersona(Persona $persona): self
    {
        $this->personas->removeElement($persona);

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
