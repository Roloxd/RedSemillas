<?php

namespace App\Entity;

use App\Repository\TerrenoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TerrenoRepository::class)
 */
class Terreno
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
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $datos_sigpac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localizacion_mapa;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $superficie_finca;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $superficie_cultivo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manejo_cultivo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo_cultivos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity=Persona::class, inversedBy="terrenos")
     */
    private $id_persona;

    /**
     * @ORM\ManyToMany(targetEntity=Entrada::class, mappedBy="id_terreno")
     */
    private $entradas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pais_origen;

    /**
     * @ORM\Column(type="boolean")
     */
    private $persona_propietaria;

    public function __construct()
    {
        $this->entradas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

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

    public function getDatosSigpac(): ?string
    {
        return $this->datos_sigpac;
    }

    public function setDatosSigpac(?string $datos_sigpac): self
    {
        $this->datos_sigpac = $datos_sigpac;

        return $this;
    }

    public function getLocalizacionMapa(): ?string
    {
        return $this->localizacion_mapa;
    }

    public function setLocalizacionMapa(?string $localizacion_mapa): self
    {
        $this->localizacion_mapa = $localizacion_mapa;

        return $this;
    }

    public function getSuperficieFinca(): ?float
    {
        return $this->superficie_finca;
    }

    public function setSuperficieFinca(?float $superficie_finca): self
    {
        $this->superficie_finca = $superficie_finca;

        return $this;
    }

    public function getSuperficieCultivo(): ?float
    {
        return $this->superficie_cultivo;
    }

    public function setSuperficieCultivo(?float $superficie_cultivo): self
    {
        $this->superficie_cultivo = $superficie_cultivo;

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

    public function getTipoCultivos(): ?string
    {
        return $this->tipo_cultivos;
    }

    public function setTipoCultivos(?string $tipo_cultivos): self
    {
        $this->tipo_cultivos = $tipo_cultivos;

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

    public function getIdPersona(): ?Persona
    {
        return $this->id_persona;
    }

    public function setIdPersona(?Persona $id_persona): self
    {
        $this->id_persona = $id_persona;

        return $this;
    }

    /**
     * @return Collection|Entrada[]
     */
    public function getEntradas(): Collection
    {
        return $this->entradas;
    }

    public function addEntrada(Entrada $entrada): self
    {
        if (!$this->entradas->contains($entrada)) {
            $this->entradas[] = $entrada;
            $entrada->addIdTerreno($this);
        }

        return $this;
    }

    public function removeEntrada(Entrada $entrada): self
    {
        if ($this->entradas->removeElement($entrada)) {
            $entrada->removeIdTerreno($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function setMunicipio(?string $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPaisOrigen(): ?string
    {
        return $this->pais_origen;
    }

    public function setPaisOrigen(?string $pais_origen): self
    {
        $this->pais_origen = $pais_origen;

        return $this;
    }

    public function getPersonaPropietaria(): ?bool
    {
        return $this->persona_propietaria;
    }

    public function setPersonaPropietaria(bool $persona_propietaria): self
    {
        $this->persona_propietaria = $persona_propietaria;

        return $this;
    }
}
