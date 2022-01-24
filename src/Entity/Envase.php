<?php

namespace App\Entity;

use App\Repository\EnvaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $cantidad_unidades;

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
    private $humedad_relativa_semilla;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $condicion_biologica;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $datos_ancestrales;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fuente_recoleccion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre_instituto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo_instituto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $estado_accesion_mls;

    /**
     * @ORM\ManyToMany(targetEntity=Variedad::class, mappedBy="envases")
     */
    private $variedads;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $codigo;

    public function __construct()
    {
        $this->variedads = new ArrayCollection();
    }

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

    public function getCantidadUnidades(): ?int
    {
        return $this->cantidad_unidades;
    }

    public function setCantidadUnidades(?int $cantidad_unidades): self
    {
        $this->cantidad_unidades = $cantidad_unidades;

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

    public function getHumedadRelativaSemilla(): ?float
    {
        return $this->humedad_relativa_semilla;
    }

    public function setHumedadRelativaSemilla(?float $humedad_relativa_semilla): self
    {
        $this->humedad_relativa_semilla = $humedad_relativa_semilla;

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

    public function getCondicionBiologica(): ?string
    {
        return $this->condicion_biologica;
    }

    public function setCondicionBiologica(?string $condicion_biologica): self
    {
        $this->condicion_biologica = $condicion_biologica;

        return $this;
    }

    public function getDatosAncestrales(): ?string
    {
        return $this->datos_ancestrales;
    }

    public function setDatosAncestrales(?string $datos_ancestrales): self
    {
        $this->datos_ancestrales = $datos_ancestrales;

        return $this;
    }

    public function getFuenteRecoleccion(): ?string
    {
        return $this->fuente_recoleccion;
    }

    public function setFuenteRecoleccion(?string $fuente_recoleccion): self
    {
        $this->fuente_recoleccion = $fuente_recoleccion;

        return $this;
    }

    public function getNombreInstituto(): ?string
    {
        return $this->nombre_instituto;
    }

    public function setNombreInstituto(?string $nombre_instituto): self
    {
        $this->nombre_instituto = $nombre_instituto;

        return $this;
    }

    public function getCodigoInstituto(): ?string
    {
        return $this->codigo_instituto;
    }

    public function setCodigoInstituto(?string $codigo_instituto): self
    {
        $this->codigo_instituto = $codigo_instituto;

        return $this;
    }

    public function getEstadoAccesionMls(): ?string
    {
        return $this->estado_accesion_mls;
    }

    public function setEstadoAccesionMls(?string $estado_accesion_mls): self
    {
        $this->estado_accesion_mls = $estado_accesion_mls;

        return $this;
    }

    public function __toString() : string
    {
        return $this->getCodigo();
    }

    /**
     * @return Collection|Variedad[]
     */
    public function getVariedads(): Collection
    {
        return $this->variedads;
    }

    public function addVariedad(Variedad $variedad): self
    {
        if (!$this->variedads->contains($variedad)) {
            $this->variedads[] = $variedad;
            $variedad->addEnvase($this);
        }

        return $this;
    }

    public function removeVariedad(Variedad $variedad): self
    {
        if ($this->variedads->removeElement($variedad)) {
            $variedad->removeEnvase($this);
        }

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(?int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }
}
