<?php

namespace App\Entity;

use App\Repository\EntradaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntradaRepository::class)
 */
class Entrada
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $codigo_entrada;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_pasaporte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $superficie_cultivo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_entrada;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo_entrada;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToMany(targetEntity=Terreno::class, inversedBy="entradas")
     */
    private $id_terreno;

    /**
     * @ORM\OneToMany(targetEntity=Envase::class, mappedBy="entrada")
     */
    private $num_envase;

    /**
     * @ORM\ManyToMany(targetEntity=Persona::class, inversedBy="entradas")
     */
    private $persona;

    public function __construct()
    {
        $this->id_terreno = new ArrayCollection();
        $this->num_envase = new ArrayCollection();
        $this->persona = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoEntrada(): ?int
    {
        return $this->codigo_entrada;
    }

    public function setCodigoEntrada(int $codigo_entrada): self
    {
        $this->codigo_entrada = $codigo_entrada;

        return $this;
    }

    public function getNumPasaporte(): ?int
    {
        return $this->num_pasaporte;
    }

    public function setNumPasaporte(?int $num_pasaporte): self
    {
        $this->num_pasaporte = $num_pasaporte;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(?float $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getSuperficieCultivo(): ?float
    {
        return $this->superficie_cultivo;
    }

    public function setSuperficieCultivo(?float $superficie_cultivo): self
    {
        $this->superficie_cultivo = $superficie_cultivo;

        return $this;
    }

    public function getFechaEntrada(): ?\DateTimeInterface
    {
        return $this->fecha_entrada;
    }

    public function setFechaEntrada(\DateTimeInterface $fecha_entrada): self
    {
        $this->fecha_entrada = $fecha_entrada;

        return $this;
    }

    public function getTipoEntrada(): ?string
    {
        return $this->tipo_entrada;
    }

    public function setTipoEntrada(?string $tipo_entrada): self
    {
        $this->tipo_entrada = $tipo_entrada;

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
     * @return Collection|Terreno[]
     */
    public function getTerrenos(): Collection
    {
        return $this->id_terreno;
    }

    public function addIdTerreno(Terreno $idTerreno): self
    {
        if (!$this->id_terreno->contains($idTerreno)) {
            $this->id_terreno[] = $idTerreno;
        }

        return $this;
    }

    public function removeIdTerreno(Terreno $idTerreno): self
    {
        $this->id_terreno->removeElement($idTerreno);

        return $this;
    }

    /**
     * @return Collection|Envase[]
     */
    public function getNumEnvase(): Collection
    {
        return $this->num_envase;
    }

    public function addNumEnvase(Envase $numEnvase): self
    {
        if (!$this->num_envase->contains($numEnvase)) {
            $this->num_envase[] = $numEnvase;
            $numEnvase->setEntrada($this);
        }

        return $this;
    }

    public function removeNumEnvase(Envase $numEnvase): self
    {
        if ($this->num_envase->removeElement($numEnvase)) {
            // set the owning side to null (unless already changed)
            if ($numEnvase->getEntrada() === $this) {
                $numEnvase->setEntrada(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return "ENT-" . $this->id;
    }

    /**
     * @return Collection|Persona[]
     */
    public function getPersona(): Collection
    {
        return $this->persona;
    }

    public function addPersona(Persona $persona): self
    {
        if (!$this->persona->contains($persona)) {
            $this->persona[] = $persona;
        }

        return $this;
    }

    public function removePersona(Persona $persona): self
    {
        $this->persona->removeElement($persona);

        return $this;
    }
}
