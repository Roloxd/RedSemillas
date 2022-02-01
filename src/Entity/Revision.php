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
    private $semillar_muertas;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $semillas_germinadas;

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
     * @ORM\ManyToOne(targetEntity=Germinacion::class, inversedBy="revisiones")
     */
    private $germinacion;

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

    public function getSemillarMuertas(): ?int
    {
        return $this->semillar_muertas;
    }

    public function setSemillarMuertas(?int $semillar_muertas): self
    {
        $this->semillar_muertas = $semillar_muertas;

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

    public function getGerminacion(): ?Germinacion
    {
        return $this->germinacion;
    }

    public function setGerminacion(?Germinacion $germinacion): self
    {
        $this->germinacion = $germinacion;

        return $this;
    }
}
