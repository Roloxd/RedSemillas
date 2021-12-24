<?php

namespace App\Entity;

use App\Repository\TaxonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxonRepository::class)
 */
class Taxon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $padre;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $autoridad;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $subtaxon;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
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
     * @ORM\OneToOne(targetEntity=Variedad::class, mappedBy="especie", cascade={"persist", "remove"})
     */
    private $variedad;

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

    public function getPadre(): ?int
    {
        return $this->padre;
    }

    public function setPadre(?int $padre): self
    {
        $this->padre = $padre;

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

    public function getVariedad(): ?Variedad
    {
        return $this->variedad;
    }

    public function setVariedad(?Variedad $variedad): self
    {
        // unset the owning side of the relation if necessary
        if ($variedad === null && $this->variedad !== null) {
            $this->variedad->setEspecie(null);
        }

        // set the owning side of the relation if necessary
        if ($variedad !== null && $variedad->getEspecie() !== $this) {
            $variedad->setEspecie($this);
        }

        $this->variedad = $variedad;

        return $this;
    }

    public function __toString(): ?string
    {
        return $this->id;
    }

}
