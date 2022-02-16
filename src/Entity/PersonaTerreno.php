<?php

namespace App\Entity;

use App\Repository\PersonaTerrenoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonaTerrenoRepository::class)
 */
class PersonaTerreno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Terreno::class, inversedBy="personaTerrenos")
     */
    private $terreno;

    /**
     * @ORM\ManyToOne(targetEntity=Persona::class, inversedBy="personaTerrenos")
     */
    private $persona;

    /**
     * @ORM\Column(type="boolean")
     */
    private $propietario;

    public function __construct()
    {
        $this->persona = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerreno(): ?Terreno
    {
        return $this->terreno;
    }

    public function setTerreno(?Terreno $terreno): self
    {
        $this->terreno = $terreno;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        $this->persona = $persona;

        return $this;
    }

    public function getPropietario(): ?bool
    {
        return $this->propietario;
    }

    public function setPropietario(bool $propietario): self
    {
        $this->propietario = $propietario;

        return $this;
    }
}
