<?php

namespace App\Entity;

use App\Repository\RevisionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RevisionRepository::class)
 */
class Revision
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_revision;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_muertas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_germinadas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_no_germinadas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_anomalas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_enfermas;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_revision_finalizacion;

    /**
     * @ORM\ManyToOne(targetEntity=Germinacion::class, inversedBy="revision")
     */
    private $germinacion;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_max;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_min;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_max;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_min;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaRevision(): ?\DateTimeInterface
    {
        return $this->fecha_revision;
    }

    public function setFechaRevision(\DateTimeInterface $fecha_revision): self
    {
        $this->fecha_revision = $fecha_revision;

        return $this;
    }

    public function getSemillasMuertas(): ?int
    {
        return $this->semillas_muertas;
    }

    public function setSemillasMuertas(?int $semillas_muertas): self
    {
        $this->semillas_muertas = $semillas_muertas;

        return $this;
    }

    public function getSemillasGerminadas(): ?int
    {
        return $this->semillas_germinadas;
    }

    public function setSemillasGerminadas(?int $semillas_germinadas): self
    {
        $this->semillas_germinadas = $semillas_germinadas;

        return $this;
    }

    public function getSemillasNoGerminadas(): ?int
    {
        return $this->semillas_no_germinadas;
    }

    public function setSemillasNoGerminadas(?int $semillas_no_germinadas): self
    {
        $this->semillas_no_germinadas = $semillas_no_germinadas;

        return $this;
    }

    public function getSemillasAnomalas(): ?int
    {
        return $this->semillas_anomalas;
    }

    public function setSemillasAnomalas(?int $semillas_anomalas): self
    {
        $this->semillas_anomalas = $semillas_anomalas;

        return $this;
    }

    public function getSemillasEnfermas(): ?int
    {
        return $this->semillas_enfermas;
    }

    public function setSemillasEnfermas(?int $semillas_enfermas): self
    {
        $this->semillas_enfermas = $semillas_enfermas;

        return $this;
    }

    public function getFechaRevisionFinalizacion(): ?\DateTimeInterface
    {
        return $this->fecha_revision_finalizacion;
    }

    public function setFechaRevisionFinalizacion(?\DateTimeInterface $fecha_revision_finalizacion): self
    {
        $this->fecha_revision_finalizacion = $fecha_revision_finalizacion;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function getGerminacion(): ?Germinacion
    {
        return $this->germinacion;
    }

    public function setGerminacion(?Germinacion $germinacion): self
    {
        $this->germinacion = $germinacion;

        return $this;
    }

    public function getTemperaturaMax(): ?float
    {
        return $this->temperatura_max;
    }

    public function setTemperaturaMax(?float $temperatura_max): self
    {
        $this->temperatura_max = $temperatura_max;

        return $this;
    }

    public function getTemperaturaMin(): ?float
    {
        return $this->temperatura_min;
    }

    public function setTemperaturaMin(?float $temperatura_min): self
    {
        $this->temperatura_min = $temperatura_min;

        return $this;
    }

    public function getHumedadMax(): ?float
    {
        return $this->humedad_max;
    }

    public function setHumedadMax(?float $humedad_max): self
    {
        $this->humedad_max = $humedad_max;

        return $this;
    }

    public function getHumedadMin(): ?float
    {
        return $this->humedad_min;
    }

    public function setHumedadMin(?float $humedad_min): self
    {
        $this->humedad_min = $humedad_min;

        return $this;
    }
}
