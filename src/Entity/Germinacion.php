<?php

namespace App\Entity;

use App\Repository\GerminacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GerminacionRepository::class)
 */
class Germinacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_semillas_para_prueba;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_final;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_dias_en_germinar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porcentaje_germinacion_muestra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porcentaje_semillas_no_germinadas_muestra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porcentaje_semillas_germinacion_anomala_muestra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $porcentaje_semillas_germinacion_enfermas_muestra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_prueba_germinacion_max;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_prueba_germinacion_min;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temperatura_prueba_germinacion_media;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_relativa_prueba_germinacion_max;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_relativa_prueba_germinacion_min;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $humedad_relativa_prueba_germinacion_media;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metodo_empleado_para_germinar;

    /**
     * @ORM\ManyToOne(targetEntity=Envase::class, inversedBy="germinaciones")
     */
    private $envase;

    /**
     * @ORM\ManyToOne(targetEntity=Variedad::class, inversedBy="germinaciones")
     */
    private $variedad;

    /**
     * @ORM\OneToMany(targetEntity=Revision::class, mappedBy="germinacion")
     */
    private $revisiones;

    public function __construct()
    {
        $this->revisiones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(?\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getNumSemillasParaPrueba(): ?int
    {
        return $this->num_semillas_para_prueba;
    }

    public function setNumSemillasParaPrueba(int $num_semillas_para_prueba): self
    {
        $this->num_semillas_para_prueba = $num_semillas_para_prueba;

        return $this;
    }

    public function getFechaFinal(): ?\DateTimeInterface
    {
        return $this->fecha_final;
    }

    public function setFechaFinal(?\DateTimeInterface $fecha_final): self
    {
        $this->fecha_final = $fecha_final;

        return $this;
    }

    public function getNumDiasEnGerminar(): ?int
    {
        return $this->num_dias_en_germinar;
    }

    public function setNumDiasEnGerminar(?int $num_dias_en_germinar): self
    {
        $this->num_dias_en_germinar = $num_dias_en_germinar;

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

    public function getPorcentajeGerminacionMuestra(): ?float
    {
        return $this->porcentaje_germinacion_muestra;
    }

    public function setPorcentajeGerminacionMuestra(?float $porcentaje_germinacion_muestra): self
    {
        $this->porcentaje_germinacion_muestra = $porcentaje_germinacion_muestra;

        return $this;
    }

    public function getPorcentajeSemillasNoGerminadasMuestra(): ?float
    {
        return $this->porcentaje_semillas_no_germinadas_muestra;
    }

    public function setPorcentajeSemillasNoGerminadasMuestra(?float $porcentaje_semillas_no_germinadas_muestra): self
    {
        $this->porcentaje_semillas_no_germinadas_muestra = $porcentaje_semillas_no_germinadas_muestra;

        return $this;
    }

    public function getPorcentajeSemillasGerminacionAnomalaMuestra(): ?float
    {
        return $this->porcentaje_semillas_germinacion_anomala_muestra;
    }

    public function setPorcentajeSemillasGerminacionAnomalaMuestra(?float $porcentaje_semillas_germinacion_anomala_muestra): self
    {
        $this->porcentaje_semillas_germinacion_anomala_muestra = $porcentaje_semillas_germinacion_anomala_muestra;

        return $this;
    }

    public function getPorcentajeSemillasGerminacionEnfermasMuestra(): ?float
    {
        return $this->porcentaje_semillas_germinacion_enfermas_muestra;
    }

    public function setPorcentajeSemillasGerminacionEnfermasMuestra(?float $porcentaje_semillas_germinacion_enfermas_muestra): self
    {
        $this->porcentaje_semillas_germinacion_enfermas_muestra = $porcentaje_semillas_germinacion_enfermas_muestra;

        return $this;
    }

    public function getTemperaturaPruebaGerminacionMax(): ?float
    {
        return $this->temperatura_prueba_germinacion_max;
    }

    public function setTemperaturaPruebaGerminacionMax(float $temperatura_prueba_germinacion_max): self
    {
        $this->temperatura_prueba_germinacion_max = $temperatura_prueba_germinacion_max;

        return $this;
    }

    public function getTemperaturaPruebaGerminacionMin(): ?float
    {
        return $this->temperatura_prueba_germinacion_min;
    }

    public function setTemperaturaPruebaGerminacionMin(?float $temperatura_prueba_germinacion_min): self
    {
        $this->temperatura_prueba_germinacion_min = $temperatura_prueba_germinacion_min;

        return $this;
    }

    public function getTemperaturaPruebaGerminacionMedia(): ?float
    {
        return $this->temperatura_prueba_germinacion_media;
    }

    public function setTemperaturaPruebaGerminacionMedia(?float $temperatura_prueba_germinacion_media): self
    {
        $this->temperatura_prueba_germinacion_media = $temperatura_prueba_germinacion_media;

        return $this;
    }

    public function getHumedadRelativaPruebaGerminacionMax(): ?float
    {
        return $this->humedad_relativa_prueba_germinacion_max;
    }

    public function setHumedadRelativaPruebaGerminacionMax(?float $humedad_relativa_prueba_germinacion_max): self
    {
        $this->humedad_relativa_prueba_germinacion_max = $humedad_relativa_prueba_germinacion_max;

        return $this;
    }

    public function getHumedadRelativaPruebaGerminacionMin(): ?float
    {
        return $this->humedad_relativa_prueba_germinacion_min;
    }

    public function setHumedadRelativaPruebaGerminacionMin(?float $humedad_relativa_prueba_germinacion_min): self
    {
        $this->humedad_relativa_prueba_germinacion_min = $humedad_relativa_prueba_germinacion_min;

        return $this;
    }

    public function getHumedadRelativaPruebaGerminacionMedia(): ?float
    {
        return $this->humedad_relativa_prueba_germinacion_media;
    }

    public function setHumedadRelativaPruebaGerminacionMedia(?float $humedad_relativa_prueba_germinacion_media): self
    {
        $this->humedad_relativa_prueba_germinacion_media = $humedad_relativa_prueba_germinacion_media;

        return $this;
    }

    public function getMetodoEmpleadoParaGerminar(): ?string
    {
        return $this->metodo_empleado_para_germinar;
    }

    public function setMetodoEmpleadoParaGerminar(?string $metodo_empleado_para_germinar): self
    {
        $this->metodo_empleado_para_germinar = $metodo_empleado_para_germinar;

        return $this;
    }

    public function getEnvase(): ?Envase
    {
        return $this->envase;
    }

    public function setEnvase(?Envase $envase): self
    {
        $this->envase = $envase;

        return $this;
    }

    public function getVariedad(): ?Variedad
    {
        return $this->variedad;
    }

    public function setVariedad(?Variedad $variedad): self
    {
        $this->variedad = $variedad;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->getId();
    }

    /**
     * @return Collection|Revision[]
     */
    public function getRevisiones(): Collection
    {
        return $this->revisiones;
    }

    public function addRevision(Revision $revision): self
    {
        if (!$this->revisiones->contains($revision)) {
            $this->revisiones[] = $revision;
            $revision->setGerminacion($this);
        }

        return $this;
    }

    public function removeRevision(Revision $revision): self
    {
        if ($this->revisiones->removeElement($revision)) {
            // set the owning side to null (unless already changed)
            if ($revision->getGerminacion() === $this) {
                $revision->setGerminacion(null);
            }
        }

        return $this;
    }
}
