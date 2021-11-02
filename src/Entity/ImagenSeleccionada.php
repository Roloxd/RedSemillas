<?php

namespace App\Entity;

use App\Repository\ImagenSeleccionadaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagenSeleccionadaRepository::class)
 */
class ImagenSeleccionada
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=Imagen::class)
     */
    private $imagen;

    /**
     * @ORM\OneToOne(targetEntity=Variedad::class, inversedBy="imagenSeleccionada", cascade={"persist", "remove"})
     */
    private $variedad;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImagen(): ?imagen
    {
        return $this->imagen;
    }

    public function setImagen(?imagen $imagen): self
    {
        $this->imagen = $imagen;

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

    public function __toString()
    {
        return $this->id;
    }
}
