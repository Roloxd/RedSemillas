<?php

namespace App\Entity;

use App\Repository\UsoRepository;
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
     * @ORM\ManyToOne(targetEntity=UsoVariedad::class, inversedBy="uso")
     */
    private $usoVariedad;

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

    public function getUsoVariedad(): ?UsoVariedad
    {
        return $this->usoVariedad;
    }

    public function setUsoVariedad(?UsoVariedad $usoVariedad): self
    {
        $this->usoVariedad = $usoVariedad;

        return $this;
    }
}
