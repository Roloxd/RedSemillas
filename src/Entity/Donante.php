<?php

namespace App\Entity;

use App\Repository\DonanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonanteRepository::class)
 * @ORM\Table(name="donante_recolector")
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

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $numeroRecolector;

    /**
     * @ORM\ManyToOne(targetEntity=Instituciones::class, inversedBy="donantes")
     */
    private $codigoInstitutoRecolector;

    /**
     * @ORM\ManyToOne(targetEntity=Instituciones::class, inversedBy="donantesMejoramiento")
     */
    private $codigoInstitutoMejoramiento;

    /**
     * @ORM\ManyToOne(targetEntity=Instituciones::class, inversedBy="donantesInstitucion")
     */
    private $instcode;

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

    public function getNumeroRecolector(): ?string
    {
        return $this->numeroRecolector;
    }

    public function setNumeroRecolector(?string $numeroRecolector): self
    {
        $this->numeroRecolector = $numeroRecolector;

        return $this;
    }

    public function getCodigoInstitutoRecolector(): ?Instituciones
    {
        return $this->codigoInstitutoRecolector;
    }

    public function setCodigoInstitutoRecolector(?Instituciones $codigoInstitutoRecolector): self
    {
        $this->codigoInstitutoRecolector = $codigoInstitutoRecolector;

        return $this;
    }

    public function getCodigoInstitutoMejoramiento(): ?Instituciones
    {
        return $this->codigoInstitutoMejoramiento;
    }

    public function setCodigoInstitutoMejoramiento(?Instituciones $codigoInstitutoMejoramiento): self
    {
        $this->codigoInstitutoMejoramiento = $codigoInstitutoMejoramiento;

        return $this;
    }

    public function getInstcode(): ?Instituciones
    {
        return $this->instcode;
    }

    public function setInstcode(?Instituciones $instcode): self
    {
        $this->instcode = $instcode;

        return $this;
    }
}
