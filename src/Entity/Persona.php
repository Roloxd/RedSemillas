<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonaRepository::class)
 */
class Persona
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $num_socio;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_inscripcion_rgcs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $acepta_condiciones;

    // /**
    //  * @ORM\Column(type="string", length=40, nullable=true)
    //  */
    // private $tipo_socio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ampliacion_cuota;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_cuota;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $recibir_informacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_informacion;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $nif;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telefono2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $relacion_agricultura;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $terreno_cultivo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscripcion_rope;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $codigo_rope;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $otras_cuestiones;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\OneToOne(targetEntity=Donante::class, inversedBy="persona")
     */
    private $donante;

    /**
     * @ORM\OneToMany(targetEntity=Pago::class, mappedBy="persona")
     */
    private $pagos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $numerario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_cuenta_corriente;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_inscripcion_numerario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $domiciliario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo_bic;

    /**
     * @ORM\OneToMany(targetEntity=PersonaTerreno::class, mappedBy="persona")
     */
    private $personaTerrenos;

    /**
     * @ORM\OneToMany(targetEntity=Entrada::class, mappedBy="persona")
     */
    private $entradas;

    public function __construct()
    {
        $this->pagos = new ArrayCollection();
        $this->personaTerrenos = new ArrayCollection();
        $this->entradas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSocio(): ?int
    {
        return $this->num_socio;
    }

    public function setNumSocio(?int $num_socio): self
    {
        $this->num_socio = $num_socio;

        return $this;
    }

    public function getFechaInscripcionRgcs(): ?\DateTimeInterface
    {
        return $this->fecha_inscripcion_rgcs;
    }

    public function setFechaInscripcionRgcs(?\DateTimeInterface $fecha_inscripcion_rgcs): self
    {
        $this->fecha_inscripcion_rgcs = $fecha_inscripcion_rgcs;

        return $this;
    }

    public function getAceptaCondiciones(): ?bool
    {
        return $this->acepta_condiciones;
    }

    public function setAceptaCondiciones(?bool $acepta_condiciones): self
    {
        $this->acepta_condiciones = $acepta_condiciones;

        return $this;
    }

    // public function getTipoSocio(): ?string
    // {
    //     return $this->tipo_socio;
    // }

    // public function setTipoSocio(?string $tipo_socio): self
    // {
    //     $this->tipo_socio = $tipo_socio;

    //     return $this;
    // }

    public function getAmpliacionCuota(): ?bool
    {
        return $this->ampliacion_cuota;
    }

    public function setAmpliacionCuota(?bool $ampliacion_cuota): self
    {
        $this->ampliacion_cuota = $ampliacion_cuota;

        return $this;
    }

    public function getFechaCuota(): ?\DateTimeInterface
    {
        return $this->fecha_cuota;
    }

    public function setFechaCuota(?\DateTimeInterface $fecha_cuota): self
    {
        $this->fecha_cuota = $fecha_cuota;

        return $this;
    }

    public function getRecibirInformacion(): ?bool
    {
        return $this->recibir_informacion;
    }

    public function setRecibirInformacion(?bool $recibir_informacion): self
    {
        $this->recibir_informacion = $recibir_informacion;

        return $this;
    }

    public function getFechaInformacion(): ?\DateTimeInterface
    {
        return $this->fecha_informacion;
    }

    public function setFechaInformacion(?\DateTimeInterface $fecha_informacion): self
    {
        $this->fecha_informacion = $fecha_informacion;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(?string $nif): self
    {
        $this->nif = $nif;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
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

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getTelefono2(): ?int
    {
        return $this->telefono2;
    }

    public function setTelefono2(?int $telefono2): self
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getRelacionAgricultura(): ?string
    {
        return $this->relacion_agricultura;
    }

    public function setRelacionAgricultura(?string $relacion_agricultura): self
    {
        $this->relacion_agricultura = $relacion_agricultura;

        return $this;
    }

    public function getTerrenoCultivo(): ?bool
    {
        return $this->terreno_cultivo;
    }

    public function setTerrenoCultivo(?bool $terreno_cultivo): self
    {
        $this->terreno_cultivo = $terreno_cultivo;

        return $this;
    }

    public function getInscripcionRope(): ?bool
    {
        return $this->inscripcion_rope;
    }

    public function setInscripcionRope(?bool $inscripcion_rope): self
    {
        $this->inscripcion_rope = $inscripcion_rope;

        return $this;
    }

    public function getCodigoRope(): ?string
    {
        return $this->codigo_rope;
    }

    public function setCodigoRope(?string $codigo_rope): self
    {
        $this->codigo_rope = $codigo_rope;

        return $this;
    }

    public function getOtrasCuestiones(): ?string
    {
        return $this->otras_cuestiones;
    }

    public function setOtrasCuestiones(?string $otras_cuestiones): self
    {
        $this->otras_cuestiones = $otras_cuestiones;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(?string $documento): self
    {
        $this->documento = $documento;

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

    public function __toString()
    {
        return $this->getNombre() . " " . $this->getApellidos();
    }

    public function getDonante(): ?Donante
    {
        return $this->donante;
    }

    public function setDonante(?Donante $donante): self
    {
        $this->donante = $donante;

        return $this;
    }

    /**
     * @return Collection|Pago[]
     */
    public function getPagos(): Collection
    {
        return $this->pagos;
    }

    public function addPago(Pago $pago): self
    {
        if (!$this->pagos->contains($pago)) {
            $this->pagos[] = $pago;
            $pago->setPersona($this);
        }

        return $this;
    }

    public function removePago(Pago $pago): self
    {
        if ($this->pagos->removeElement($pago)) {
            // set the owning side to null (unless already changed)
            if ($pago->getPersona() === $this) {
                $pago->setPersona(null);
            }
        }

        return $this;
    }

    public function getNumerario(): ?bool
    {
        return $this->numerario;
    }

    public function setNumerario(bool $numerario): self
    {
        $this->numerario = $numerario;

        return $this;
    }

    public function getNumeroCuentaCorriente(): ?string
    {
        return $this->numero_cuenta_corriente;
    }

    public function setNumeroCuentaCorriente(?string $numero_cuenta_corriente): self
    {
        $this->numero_cuenta_corriente = $numero_cuenta_corriente;

        return $this;
    }

    public function getFechaInscripcionNumerario(): ?\DateTimeInterface
    {
        return $this->fecha_inscripcion_numerario;
    }

    public function setFechaInscripcionNumerario(?\DateTimeInterface $fecha_inscripcion_numerario): self
    {
        $this->fecha_inscripcion_numerario = $fecha_inscripcion_numerario;

        return $this;
    }

    public function getDomiciliario(): ?bool
    {
        return $this->domiciliario;
    }

    public function setDomiciliario(bool $domiciliario): self
    {
        $this->domiciliario = $domiciliario;

        return $this;
    }

    public function getCodigoBic(): ?string
    {
        return $this->codigo_bic;
    }

    public function setCodigoBic(?string $codigo_bic): self
    {
        $this->codigo_bic = $codigo_bic;

        return $this;
    }

    /**
     * @return Collection|PersonaTerreno[]
     */
    public function getPersonaTerrenos(): Collection
    {
        return $this->personaTerrenos;
    }

    public function addPersonaTerreno(PersonaTerreno $personaTerreno): self
    {
        if (!$this->personaTerrenos->contains($personaTerreno)) {
            $this->personaTerrenos[] = $personaTerreno;
            $personaTerreno->setPersona($this);
        }

        return $this;
    }

    public function removePersonaTerreno(PersonaTerreno $personaTerreno): self
    {
        if ($this->personaTerrenos->removeElement($personaTerreno)) {
            // set the owning side to null (unless already changed)
            if ($personaTerreno->getPersona() === $this) {
                $personaTerreno->setPersona(null);
            }
        }

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
            $entrada->setPersona($this);
        }

        return $this;
    }

    public function removeEntrada(Entrada $entrada): self
    {
        if ($this->entradas->removeElement($entrada)) {
            // set the owning side to null (unless already changed)
            if ($entrada->getPersona() === $this) {
                $entrada->setPersona(null);
            }
        }

        return $this;
    }
}
