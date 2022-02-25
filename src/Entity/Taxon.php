<?php

namespace App\Entity;

use App\Repository\TaxonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxonRepository::class)
 * @ORM\Table(name="taxon_wfo")
 */
class Taxon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string", length=255)
     * @ORM\OneToMany(targetEntity=Taxon::class, mappedBy="padre")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autoridad;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $subtaxon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autoridad_subtaxon;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Taxon::class, inversedBy="id")
     */
    private $padre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $no_wfo;

    /**
     * @ORM\OneToMany(targetEntity=Variedad::class, mappedBy="especie")
     */
    private $variedades;

    public function __construct()
    {
        $this->variedades = new ArrayCollection();
    }

    // public function __construct()
    // {
    //     $this->Taxon = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAutoridad(): ?string
    {
        return $this->autoridad;
    }

    public function setAutoridad(?string $autoridad): self
    {
        $this->autoridad = $autoridad;

        return $this;
    }

    public function getSubtaxon(): ?string
    {
        return $this->subtaxon;
    }

    public function setSubtaxon(string $subtaxon): self
    {
        $this->subtaxon = $subtaxon;

        return $this;
    }

    public function getAutoridadSubtaxon(): ?string
    {
        return $this->autoridad_subtaxon;
    }

    public function setAutoridadSubtaxon(?string $autoridad_subtaxon): self
    {
        $this->autoridad_subtaxon = $autoridad_subtaxon;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombre();
    }

    public function getPadre(): ?self
    {
        return $this->padre;
    }

    public function setPadre(?self $padre): self
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTaxon(): Collection
    {
        return $this->id;
    }

    public function getNoWfo(): ?bool
    {
        return $this->no_wfo;
    }

    public function setNoWfo(bool $no_wfo): self
    {
        $this->no_wfo = $no_wfo;

        return $this;
    }

    /**
     * @return Collection|Variedad[]
     */
    public function getVariedades(): Collection
    {
        return $this->variedades;
    }

    public function addVariedade(Variedad $variedade): self
    {
        if (!$this->variedades->contains($variedade)) {
            $this->variedades[] = $variedade;
            $variedade->setEspecie($this);
        }

        return $this;
    }

    public function removeVariedade(Variedad $variedade): self
    {
        if ($this->variedades->removeElement($variedade)) {
            // set the owning side to null (unless already changed)
            if ($variedade->getEspecie() === $this) {
                $variedade->setEspecie(null);
            }
        }

        return $this;
    }
}
