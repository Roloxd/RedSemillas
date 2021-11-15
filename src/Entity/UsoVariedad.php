<?php

namespace App\Entity;

use App\Repository\UsoVariedadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsoVariedadRepository::class)
 */
class UsoVariedad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Uso::class, inversedBy="usoVariedads")
     */
    private $uso;

    /**
     * @ORM\ManyToOne(targetEntity=Variedad::class, inversedBy="usoVariedads")
     */
    private $variedad;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUso(): ?Uso
    {
        return $this->uso;
    }

    public function setUso(?Uso $uso): self
    {
        $this->uso = $uso;

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
}
