<?php

namespace App\Entity;

use App\Repository\EnvaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnvaseRepository::class)
 */
class Envase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo_almacenamiento;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_envasado;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ubicacion_envase;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cantidad_gramos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cantidad_unidaddes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $unidades_viables;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_envasado;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_relativa_envasar;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_relativa_simple;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cantidad_min_seguridad;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cantidad_min_unidades;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $unidades_gramo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $disponibilidad_red;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $conservacion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity=Entrada::class, inversedBy="num_envase")
     */
    private $entrada;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoAlmacenamiento(): ?string
    {
        return $this->tipo_almacenamiento;
    }

    public function setTipoAlmacenamiento(?string $tipo_almacenamiento): self
    {
        $this->tipo_almacenamiento = $tipo_almacenamiento;

        return $this;
    }

    public function getFechaEnvasado(): ?\DateTimeInterface
    {
        return $this->fecha_envasado;
    }

    public function setFechaEnvasado(\DateTimeInterface $fecha_envasado): self
    {
        $this->fecha_envasado = $fecha_envasado;

        return $this;
    }

    public function getUbicacionEnvase(): ?string
    {
        return $this->ubicacion_envase;
    }

    public function setUbicacionEnvase(?string $ubicacion_envase): self
    {
        $this->ubicacion_envase = $ubicacion_envase;

        return $this;
    }

    public function getCantidadGramos(): ?float
    {
        return $this->cantidad_gramos;
    }

    public function setCantidadGramos(?float $cantidad_gramos): self
    {
        $this->cantidad_gramos = $cantidad_gramos;

        return $this;
    }

    public function getCantidadUnidaddes(): ?int
    {
        return $this->cantidad_unidaddes;
    }

    public function setCantidadUnidaddes(?int $cantidad_unidaddes): self
    {
        $this->cantidad_unidaddes = $cantidad_unidaddes;

        return $this;
    }

    public function getUnidadesViables(): ?int
    {
        return $this->unidades_viables;
    }

    public function setUnidadesViables(?int $unidades_viables): self
    {
        $this->unidades_viables = $unidades_viables;

        return $this;
    }

    public function getTemperaturaEnvasado(): ?float
    {
        return $this->temperatura_envasado;
    }

    public function setTemperaturaEnvasado(?float $temperatura_envasado): self
    {
        $this->temperatura_envasado = $temperatura_envasado;

        return $this;
    }

    public function getHumedadRelativaEnvasar(): ?float
    {
        return $this->humedad_relativa_envasar;
    }

    public function setHumedadRelativaEnvasar(?float $humedad_relativa_envasar): self
    {
        $this->humedad_relativa_envasar = $humedad_relativa_envasar;

        return $this;
    }

    public function getHumedadRelativaSimple(): ?float
    {
        return $this->humedad_relativa_simple;
    }

    public function setHumedadRelativaSimple(?float $humedad_relativa_simple): self
    {
        $this->humedad_relativa_simple = $humedad_relativa_simple;

        return $this;
    }

    public function getCantidadMinSeguridad(): ?float
    {
        return $this->cantidad_min_seguridad;
    }

    public function setCantidadMinSeguridad(?float $cantidad_min_seguridad): self
    {
        $this->cantidad_min_seguridad = $cantidad_min_seguridad;

        return $this;
    }

    public function getCantidadMinUnidades(): ?float
    {
        return $this->cantidad_min_unidades;
    }

    public function setCantidadMinUnidades(?float $cantidad_min_unidades): self
    {
        $this->cantidad_min_unidades = $cantidad_min_unidades;

        return $this;
    }

    public function getUnidadesGramo(): ?float
    {
        return $this->unidades_gramo;
    }

    public function setUnidadesGramo(?float $unidades_gramo): self
    {
        $this->unidades_gramo = $unidades_gramo;

        return $this;
    }

    public function getDisponibilidadRed(): ?string
    {
        return $this->disponibilidad_red;
    }

    public function setDisponibilidadRed(?string $disponibilidad_red): self
    {
        $this->disponibilidad_red = $disponibilidad_red;

        return $this;
    }

    public function getConservacion(): ?bool
    {
        return $this->conservacion;
    }

    public function setConservacion(?bool $conservacion): self
    {
        $this->conservacion = $conservacion;

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
