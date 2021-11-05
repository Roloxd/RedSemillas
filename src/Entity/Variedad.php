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
     * @ORM\Column(name="especie", type="string", type="string", length=45, nullable=true)
     */
    private $especie;
    /**
     * @var string|null
     *
     * @ORM\Column(name="familia", type="string", length=45, nullable=true)
     */
    private $familia;
    /**
     * @var string|null
     *
     * @ORM\Column(name="genero", type="string", length=45, nullable=true)
     */
    private $genero;
   
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
     * @var int|null
     *
     * @ORM\Column(name="caracterizacion", type="integer", nullable=true, options={"comment"="de momento no hay ficha de caracterización. Fase 2."})
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
     * @ORM\ManyToOne(targetEntity=UsoVariedad::class, inversedBy="variedad")
     */
    private $usoVariedad;

    /**
     * @ORM\OneToOne(targetEntity=ImagenSeleccionada::class, mappedBy="variedad", cascade={"persist", "remove"})
     */
    private $imagenSeleccionada;

    /**
     * @ORM\OneToMany(targetEntity=CicloYSiembra::class, mappedBy="variedad")
     */
    private $cicloYSiembras;

    /**
     * @ORM\OneToOne(targetEntity=Taxon::class, inversedBy="variedad", cascade={"persist", "remove"})
     */
    private $subtaxon;

    public function __construct()
    {
        $this->cicloYSiembras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getEspecie(): ?string
    {
        return $this->especie;
    }

    public function setEspecie(?string $especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function getFamilia(): ?string
    {
        return $this->familia;
    }
	
    public function getGenero(): ?string
    {
        return $this->genero;
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

    public function getCaracterizacion(): ?int
    {
        return $this->caracterizacion;
    }

    public function setCaracterizacion(?int $caracterizacion): self
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

    public function __toString() {
        return $this->nombreComun;
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

    public function getUsoVariedad(): ?UsoVariedad
    {
        return $this->usoVariedad;
    }

    public function setUsoVariedad(?UsoVariedad $usoVariedad): self
    {
        $this->usoVariedad = $usoVariedad;

        return $this;
    }

    public function getImagenSeleccionada(): ?ImagenSeleccionada
    {
        return $this->imagenSeleccionada;
    }

    public function setImagenSeleccionada(?ImagenSeleccionada $imagenSeleccionada): self
    {
        // unset the owning side of the relation if necessary
        if ($imagenSeleccionada === null && $this->imagenSeleccionada !== null) {
            $this->imagenSeleccionada->setVariedad(null);
        }

        // set the owning side of the relation if necessary
        if ($imagenSeleccionada !== null && $imagenSeleccionada->getVariedad() !== $this) {
            $imagenSeleccionada->setVariedad($this);
        }

        $this->imagenSeleccionada = $imagenSeleccionada;

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

    public function getSubtaxon(): ?Taxon
    {
        return $this->subtaxon;
    }

    public function setSubtaxon(?Taxon $subtaxon): self
    {
        $this->subtaxon = $subtaxon;

        return $this;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
