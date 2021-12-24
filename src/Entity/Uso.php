<?php

namespace App\Entity;

use App\Repository\UsoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsoRepository::class)
 */
class Uso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $uso;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\OneToMany(targetEntity=UsoVariedad::class, mappedBy="uso")
     */
    private $usoVariedads;

    public function __construct()
    {
        $this->usoVariedads = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity=UsoVariedad::class, mappedBy="uso")
     */
    private $usoVariedads;

    public function __construct()
    {
        $this->usoVariedads = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity=UsoVariedad::class, mappedBy="uso")
     */
    private $usoVariedads;

    public function __construct()
    {
        $this->usoVariedads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUso(): ?string
    {
        return $this->uso;
    }

    public function setUso(?string $uso): self
    {
        $this->uso = $uso;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

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
            $usoVariedad->setUso($this);
        }

        return $this;
    }

    public function removeUsoVariedad(UsoVariedad $usoVariedad): self
    {
        if ($this->usoVariedads->removeElement($usoVariedad)) {
            // set the owning side to null (unless already changed)
            if ($usoVariedad->getUso() === $this) {
                $usoVariedad->setUso(null);
            }
        }

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
            $usoVariedad->setUso($this);
        }

        return $this;
    }

    public function removeUsoVariedad(UsoVariedad $usoVariedad): self
    {
        if ($this->usoVariedads->removeElement($usoVariedad)) {
            // set the owning side to null (unless already changed)
            if ($usoVariedad->getUso() === $this) {
                $usoVariedad->setUso(null);
            }
        }

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
            $usoVariedad->setUso($this);
        }

        return $this;
    }

    public function removeUsoVariedad(UsoVariedad $usoVariedad): self
    {
        if ($this->usoVariedads->removeElement($usoVariedad)) {
            // set the owning side to null (unless already changed)
            if ($usoVariedad->getUso() === $this) {
                $usoVariedad->setUso(null);
            }
        }

        return $this;
    }
}
