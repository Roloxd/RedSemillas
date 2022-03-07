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
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codigo_entrada;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $num_pasaporte;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\Column(type="date", nullable=true)
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
     * @ORM\ManyToOne(targetEntity=Persona::class, inversedBy="entradas")
     */
    private $persona;

    /**
     * @ORM\OneToOne(targetEntity=Mejoras::class, mappedBy="entrada", cascade={"persist", "remove"})
     */
    private $mejoras;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cantidadUnidades;

    /**
     * @ORM\OneToMany(targetEntity=Fitosanitario::class, mappedBy="entrada")
     */
    private $fitosanitarios;

    /**
     * @ORM\OneToMany(targetEntity=Germinacion::class, mappedBy="entrada")
     */
    private $germinaciones;

    public function __construct()
    {
        $this->id_terreno = new ArrayCollection();
        $this->num_envase = new ArrayCollection();
        $this->fitosanitarios = new ArrayCollection();
        $this->germinaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoEntrada(): ?string
    {
        return $this->codigo_entrada;
    }

    public function setCodigoEntrada(string $codigo_entrada): self
    {
        $this->codigo_entrada = $codigo_entrada;

        return $this;
    }

    public function getNumPasaporte(): ?string
    {
        return $this->num_pasaporte;
    }

    public function setNumPasaporte(?string $num_pasaporte): self
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
        return $this->getCodigoEntrada();
    }

    public function getCodigoEntradaAndPasaporte(): string 
    {
        return $this->getCodigoEntrada() . " - " . $this->getNumPasaporte(); 
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        $this->persona = $persona;

        return $this;
    }

    public function getMejoras(): ?Mejoras
    {
        return $this->mejoras;
    }

    public function setMejoras(?Mejoras $mejoras): self
    {
        // unset the owning side of the relation if necessary
        if ($mejoras === null && $this->mejoras !== null) {
            $this->mejoras->setEntrada(null);
        }

        // set the owning side of the relation if necessary
        if ($mejoras !== null && $mejoras->getEntrada() !== $this) {
            $mejoras->setEntrada($this);
        }

        $this->mejoras = $mejoras;

        return $this;
    }

    public function getCantidadUnidades(): ?int
    {
        return $this->cantidadUnidades;
    }

    public function setCantidadUnidades(?int $cantidadUnidades): self
    {
        $this->cantidadUnidades = $cantidadUnidades;

        return $this;
    }

    /**
     * @return Collection|Fitosanitario[]
     */
    public function getFitosanitarios(): Collection
    {
        return $this->fitosanitarios;
    }

    public function addFitosanitario(Fitosanitario $fitosanitario): self
    {
        if (!$this->fitosanitarios->contains($fitosanitario)) {
            $this->fitosanitarios[] = $fitosanitario;
            $fitosanitario->setEntrada($this);
        }

        return $this;
    }

    public function removeFitosanitario(Fitosanitario $fitosanitario): self
    {
        if ($this->fitosanitarios->removeElement($fitosanitario)) {
            // set the owning side to null (unless already changed)
            if ($fitosanitario->getEntrada() === $this) {
                $fitosanitario->setEntrada(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Germinacion[]
     */
    public function getGerminaciones(): Collection
    {
        return $this->germinaciones;
    }

    public function addGerminacione(Germinacion $germinacione): self
    {
        if (!$this->germinaciones->contains($germinacione)) {
            $this->germinaciones[] = $germinacione;
            $germinacione->setEntrada($this);
        }

        return $this;
    }

    public function removeGerminacione(Germinacion $germinacione): self
    {
        if ($this->germinaciones->removeElement($germinacione)) {
            // set the owning side to null (unless already changed)
            if ($germinacione->getEntrada() === $this) {
                $germinacione->setEntrada(null);
            }
        }

        return $this;
    }
}
