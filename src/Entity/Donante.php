<?php

namespace App\Entity;

use App\Repository\DonanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonanteRepository::class)
 */
class Donante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo_donante;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instcode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $proyecto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_accesion_donante;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\OneToOne(targetEntity=Persona::class, mappedBy="donante")
     */
    private $persona;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoDonante(): ?string
    {
        return $this->tipo_donante;
    }

    public function setTipoDonante(string $tipo_donante): self
    {
        $this->tipo_donante = $tipo_donante;

        return $this;
    }

    public function getInstcode(): ?string
    {
        return $this->instcode;
    }

    public function setInstcode(?string $instcode): self
    {
        $this->instcode = $instcode;

        return $this;
    }

    public function getProyecto(): ?string
    {
        return $this->proyecto;
    }

    public function setProyecto(?string $proyecto): self
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    public function getNumAccesionDonante(): ?string
    {
        return $this->num_accesion_donante;
    }

    public function setNumAccesionDonante(?string $num_accesion_donante): self
    {
        $this->num_accesion_donante = $num_accesion_donante;

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

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        // unset the owning side of the relation if necessary
        if ($persona === null && $this->persona !== null) {
            $this->persona->setDonante(null);
        }

        // set the owning side of the relation if necessary
        if ($persona !== null && $persona->getDonante() !== $this) {
            $persona->setDonante($this);
        }

        $this->persona = $persona;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
