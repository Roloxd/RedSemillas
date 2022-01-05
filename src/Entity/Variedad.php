<?php

namespace App\Entity;

use App\Repository\VariedadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VariedadRepository::class)
 */
class Variedad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
    */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_comun", type="string", length=45, nullable=true, options={"comment"="Nombre común del cultivo"})
     */
    private $nombreComun;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_local", type="string", length=45, nullable=true)
     */
    private $nombreLocal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=1000, nullable=true)
     */
    private $descripcion;	
    /**
     * @var string|null
     *
     * @ORM\Column(name="tipo_siembra", type="string", length=12, nullable=true, options={"comment"="ENUM('directa','semillero','voleo')"})
     */
    private $tipoSiembra;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dias_semillero", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $diasSemillero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marco_a", type="decimal", precision=4, scale=3, nullable=true)
     */
    private $marcoA;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marco_b", type="decimal", precision=4, scale=3, nullable=true)
     */
    private $marcoB;

    /**
     * @var string|null
     *
     * @ORM\Column(name="densidad", type="decimal", precision=4, scale=3, nullable=true)
     */
    private $densidad;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ciclo_cultivo", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $cicloCultivo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="polinizacion", type="string", length=10, nullable=true, options={"comment"="ENUM('alógama','autógama','mixta')"})
     */
    private $polinizacion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="caracterizacion", type="boolean", nullable=true, options={"comment"="de momento no hay ficha de caracterización. Fase 2."})
     */
    private $caracterizacion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="viabilidad_min", type="integer", nullable=true)
     */
    private $viabilidadMin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="viabilidad_max", type="integer", nullable=true)
     */
    private $viabilidadMax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conocimientos_tradicionales", type="string", length=60, nullable=true)
     */
    private $conocimientosTradicionales;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cm_planta", type="text", length=65535, nullable=true)
     */
    private $cmPlanta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cm_flor", type="text", length=65535, nullable=true)
     */
    private $cmFlor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cm_fruto", type="text", length=65535, nullable=true)
     */
    private $cmFruto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cm_semilla", type="text", length=65535, nullable=true)
     */
    private $cmSemilla;

    /**
     * @var string|null
     *
     * @ORM\Column(name="c_argonomicas", type="text", length=65535, nullable=true)
     */
    private $cArgonomicas;

    /**
     * @var string|null
     *
     * @ORM\Column(name="c_organolepticas", type="text", length=65535, nullable=true)
     */
    private $cOrganolepticas;

    /**
     * @var string|null
     *
     * @ORM\Column(name="propagacion", type="text", length=65535, nullable=true)
     */
    private $propagacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otros", type="text", length=65535, nullable=true)
     */
    private $otros;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\OneToMany(targetEntity=ImagenSeleccionada::class, mappedBy="variedad")
     */
    private $imagenSeleccionadas;

    /**
     * @ORM\OneToMany(targetEntity=CicloYSiembra::class, mappedBy="variedad")
     */
    private $cicloYSiembras;

    /**
     * @ORM\OneToOne(targetEntity=Taxon::class, inversedBy="variedad")
     */
    private $especie;

    /**
     * @ORM\OneToMany(targetEntity=UsoVariedad::class, mappedBy="variedad")
     */
    private $usoVariedads;

    /**
     * @ORM\Column(type="integer", length=9, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $breve_descr_planta_cultivo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_cultivo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_siembra_plantacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_suelo_desherbado;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_asociacion_rotacion_cultivos;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_poda_entutorado;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_abonado_riego;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_plagas_enfermedades;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manejo_cosecha_conservacion;

    /**
     * @ORM\ManyToMany(targetEntity=Envase::class, inversedBy="variedads")
     */
    private $envases;

    public function __construct()
    {
        $this->cicloYSiembras = new ArrayCollection();
        $this->usoVariedads = new ArrayCollection();
        $this->imagenSeleccionadas = new ArrayCollection();
        $this->envases = new ArrayCollection();
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function setId(?int $id): self
    // {
    //     $this->id = $id;

    //     return $this;
    // }

    public function getNombreComun(): ?string
    {
        return $this->nombreComun;
    }

    public function setNombreComun(?string $nombreComun): self
    {
        $this->nombreComun = $nombreComun;

        return $this;
    }

    public function getNombreLocal(): ?string
    {
        return $this->nombreLocal;
    }

    public function setNombreLocal(?string $nombreLocal): self
    {
        $this->nombreLocal = $nombreLocal;

        return $this;
    }
	
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getTipoSiembra(): ?string
    {
        return $this->tipoSiembra;
    }

    public function setTipoSiembra(?string $tipoSiembra): self
    {
        $this->tipoSiembra = $tipoSiembra;

        return $this;
    }

    public function getDiasSemillero(): ?int
    {
        return $this->diasSemillero;
    }

    public function setDiasSemillero(?int $diasSemillero): self
    {
        $this->diasSemillero = $diasSemillero;

        return $this;
    }

    public function getMarcoA(): ?string
    {
        return $this->marcoA;
    }

    public function setMarcoA(?string $marcoA): self
    {
        $this->marcoA = $marcoA;

        return $this;
    }

    public function getMarcoB(): ?string
    {
        return $this->marcoB;
    }

    public function setMarcoB(?string $marcoB): self
    {
        $this->marcoB = $marcoB;

        return $this;
    }

    public function getDensidad(): ?string
    {
        return $this->densidad;
    }

    public function setDensidad(?string $densidad): self
    {
        $this->densidad = $densidad;

        return $this;
    }

    public function getCicloCultivo(): ?int
    {
        return $this->cicloCultivo;
    }

    public function setCicloCultivo(?int $cicloCultivo): self
    {
        $this->cicloCultivo = $cicloCultivo;

        return $this;
    }

    public function getPolinizacion(): ?string
    {
        return $this->polinizacion;
    }

    public function setPolinizacion(?string $polinizacion): self
    {
        $this->polinizacion = $polinizacion;

        return $this;
    }

    public function getCaracterizacion(): ?bool
    {
        return $this->caracterizacion;
    }

    public function setCaracterizacion(?bool $caracterizacion): self
    {
        $this->caracterizacion = $caracterizacion;

        return $this;
    }

    public function getViabilidadMin(): ?int
    {
        return $this->viabilidadMin;
    }

    public function setViabilidadMin(?int $viabilidadMin): self
    {
        $this->viabilidadMin = $viabilidadMin;

        return $this;
    }

    public function getViabilidadMax(): ?int
    {
        return $this->viabilidadMax;
    }

    public function setViabilidadMax(?int $viabilidadMax): self
    {
        $this->viabilidadMax = $viabilidadMax;

        return $this;
    }

    public function getConocimientosTradicionales(): ?string
    {
        return $this->conocimientosTradicionales;
    }

    public function setConocimientosTradicionales(?string $conocimientosTradicionales): self
    {
        $this->conocimientosTradicionales = $conocimientosTradicionales;

        return $this;
    }

    public function getCmPlanta(): ?string
    {
        return $this->cmPlanta;
    }

    public function setCmPlanta(?string $cmPlanta): self
    {
        $this->cmPlanta = $cmPlanta;

        return $this;
    }

    public function getCmFlor(): ?string
    {
        return $this->cmFlor;
    }

    public function setCmFlor(?string $cmFlor): self
    {
        $this->cmFlor = $cmFlor;

        return $this;
    }

    public function getCmFruto(): ?string
    {
        return $this->cmFruto;
    }

    public function setCmFruto(?string $cmFruto): self
    {
        $this->cmFruto = $cmFruto;

        return $this;
    }

    public function getCmSemilla(): ?string
    {
        return $this->cmSemilla;
    }

    public function setCmSemilla(?string $cmSemilla): self
    {
        $this->cmSemilla = $cmSemilla;

        return $this;
    }

    public function getCArgonomicas(): ?string
    {
        return $this->cArgonomicas;
    }

    public function setCArgonomicas(?string $cArgonomicas): self
    {
        $this->cArgonomicas = $cArgonomicas;

        return $this;
    }

    public function getCOrganolepticas(): ?string
    {
        return $this->cOrganolepticas;
    }

    public function setCOrganolepticas(?string $cOrganolepticas): self
    {
        $this->cOrganolepticas = $cOrganolepticas;

        return $this;
    }

    public function getPropagacion(): ?string
    {
        return $this->propagacion;
    }

    public function setPropagacion(?string $propagacion): self
    {
        $this->propagacion = $propagacion;

        return $this;
    }

    public function getOtros(): ?string
    {
        return $this->otros;
    }

    public function setOtros(?string $otros): self
    {
        $this->otros = $otros;

        return $this;
    }

    // public function __toString(): ?string
    // {
    //     return $this->id;
    // }

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
     * @return Collection|ImagenSeleccionada[]
     */
    public function getImagenSeleccionadas(): Collection
    {
        return $this->imagenSeleccionadas;
    }

    public function addImagenSeleccionada(ImagenSeleccionada $imagenSeleccionada): self
    {
        if (!$this->imagenSeleccionadas->contains($imagenSeleccionada)) {
            $this->imagenSeleccionadas[] = $imagenSeleccionada;
            $imagenSeleccionada->setVariedad($this);
        }

        return $this;
    }

    public function removeImagenSeleccionada(ImagenSeleccionada $imagenSeleccionada): self
    {
        if ($this->imagenSeleccionadas->removeElement($imagenSeleccionada)) {
            // set the owning side to null (unless already changed)
            if ($imagenSeleccionada->setVariedad() === $this) {
                $imagenSeleccionada->setVariedad(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CicloYSiembra[]
     */
    public function getCicloYSiembras(): Collection
    {
        return $this->cicloYSiembras;
    }

    public function addCicloYSiembra(CicloYSiembra $cicloYSiembra): self
    {
        if (!$this->cicloYSiembras->contains($cicloYSiembra)) {
            $this->cicloYSiembras[] = $cicloYSiembra;
            $cicloYSiembra->setVariedad($this);
        }

        return $this;
    }

    public function removeCicloYSiembra(CicloYSiembra $cicloYSiembra): self
    {
        if ($this->cicloYSiembras->removeElement($cicloYSiembra)) {
            // set the owning side to null (unless already changed)
            if ($cicloYSiembra->getVariedad() === $this) {
                $cicloYSiembra->setVariedad(null);
            }
        }

        return $this;
    }

    public function getEspecie(): ?Taxon
    {
        return $this->especie;
    }

    public function setEspecie(?Taxon $especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|UsoVariedad[]
     */
    public function getUsoVariedads(): Collection
    {
        return $this->usoVariedads;
    }

    public function addUsoVariedad(UsoVariedad $usoVariedad): self
    {
        if (!$this->usoVariedads->contains($usoVariedad)) {
            $this->usoVariedads[] = $usoVariedad;
            $usoVariedad->setVariedad($this);
        }

        return $this;
    }

    public function removeUsoVariedad(UsoVariedad $usoVariedad): self
    {
        if ($this->usoVariedads->removeElement($usoVariedad)) {
            // set the owning side to null (unless already changed)
            if ($usoVariedad->getVariedad() === $this) {
                $usoVariedad->setVariedad(null);
            }
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

    public function getBreveDescrPlantaCultivo(): ?string
    {
        return $this->breve_descr_planta_cultivo;
    }

    public function setBreveDescrPlantaCultivo(?string $breve_descr_planta_cultivo): self
    {
        $this->breve_descr_planta_cultivo = $breve_descr_planta_cultivo;

        return $this;
    }

    public function getManejoCultivo(): ?string
    {
        return $this->manejo_cultivo;
    }

    public function setManejoCultivo(?string $manejo_cultivo): self
    {
        $this->manejo_cultivo = $manejo_cultivo;

        return $this;
    }

    public function getManejoSiembraPlantacion(): ?string
    {
        return $this->manejo_siembra_plantacion;
    }

    public function setManejoSiembraPlantacion(?string $manejo_siembra_plantacion): self
    {
        $this->manejo_siembra_plantacion = $manejo_siembra_plantacion;

        return $this;
    }

    public function getManejoSueloDesherbado(): ?string
    {
        return $this->manejo_suelo_desherbado;
    }

    public function setManejoSueloDesherbado(?string $manejo_suelo_desherbado): self
    {
        $this->manejo_suelo_desherbado = $manejo_suelo_desherbado;

        return $this;
    }

    public function getManejoAsociacionRotacionCultivos(): ?string
    {
        return $this->manejo_asociacion_rotacion_cultivos;
    }

    public function setManejoAsociacionRotacionCultivos(?string $manejo_asociacion_rotacion_cultivos): self
    {
        $this->manejo_asociacion_rotacion_cultivos = $manejo_asociacion_rotacion_cultivos;

        return $this;
    }

    public function getManejoPodaEntutorado(): ?string
    {
        return $this->manejo_poda_entutorado;
    }

    public function setManejoPodaEntutorado(?string $manejo_poda_entutorado): self
    {
        $this->manejo_poda_entutorado = $manejo_poda_entutorado;

        return $this;
    }

    public function getManejoAbonadoRiego(): ?string
    {
        return $this->manejo_abonado_riego;
    }

    public function setManejoAbonadoRiego(?string $manejo_abonado_riego): self
    {
        $this->manejo_abonado_riego = $manejo_abonado_riego;

        return $this;
    }

    public function getManejoPlagasEnfermedades(): ?string
    {
        return $this->manejo_plagas_enfermedades;
    }

    public function setManejoPlagasEnfermedades(?string $manejo_plagas_enfermedades): self
    {
        $this->manejo_plagas_enfermedades = $manejo_plagas_enfermedades;

        return $this;
    }

    public function getManejoCosechaConservacion(): ?string
    {
        return $this->manejo_cosecha_conservacion;
    }

    public function setManejoCosechaConservacion(?string $manejo_cosecha_conservacion): self
    {
        $this->manejo_cosecha_conservacion = $manejo_cosecha_conservacion;

        return $this;
    }

    /**
     * @return Collection|Envase[]
     */
    public function getEnvases(): Collection
    {
        return $this->envases;
    }

    public function addEnvase(Envase $envase): self
    {
        if (!$this->envases->contains($envase)) {
            $this->envases[] = $envase;
        }

        return $this;
    }

    public function removeEnvase(Envase $envase): self
    {
        $this->envases->removeElement($envase);

        return $this;
    }
}
