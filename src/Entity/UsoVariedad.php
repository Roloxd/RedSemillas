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
     * @ORM\OneToMany(targetEntity=Variedad::class, mappedBy="usoVariedad")
     */
    private $variedad;

    /**
     * @ORM\OneToMany(targetEntity=Uso::class, mappedBy="usoVariedad")
     */
    private $uso;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    public function __construct()
    {
        $this->variedad = new ArrayCollection();
        $this->uso = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Variedad[]
     */
    public function getVariedad(): Collection
    {
        return $this->variedad;
    }

    public function addVariedad(Variedad $variedad): self
    {
        if (!$this->variedad->contains($variedad)) {
            $this->variedad[] = $variedad;
            $variedad->setUsoVariedad($this);
        }

        return $this;
    }

    public function removeVariedad(Variedad $variedad): self
    {
        if ($this->variedad->removeElement($variedad)) {
            // set the owning side to null (unless already changed)
            if ($variedad->getUsoVariedad() === $this) {
                $variedad->setUsoVariedad(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Uso[]
     */
    public function getUso(): Collection
    {
        return $this->uso;
    }

    public function addUso(Uso $uso): self
    {
        if (!$this->uso->contains($uso)) {
            $this->uso[] = $uso;
            $uso->setUsoVariedad($this);
        }

        return $this;
    }

    public function removeUso(Uso $uso): self
    {
        if ($this->uso->removeElement($uso)) {
            // set the owning side to null (unless already changed)
            if ($uso->getUsoVariedad() === $this) {
                $uso->setUsoVariedad(null);
            }
        }

        return $this;
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
}
