<?php

namespace App\Entity;

use App\Repository\ImagenSeleccionadaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToOne(targetEntity=Variedad::class, inversedBy="imagenSeleccionada", cascade={"persist", "remove"})
     */
    private $variedad;

    /**
     * @ORM\OneToMany(targetEntity=Imagen::class, mappedBy="imagenSeleccionada")
     */
    private $imagen;

    public function __construct()
    {
        $this->imagen = new ArrayCollection();
    }

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

    /**
     * @return Collection|Imagen[]
     */
    public function getImagen(): Collection
    {
        return $this->imagen;
    }

    public function addImagen(Imagen $imagen): self
    {
        if (!$this->imagen->contains($imagen)) {
            $this->imagen[] = $imagen;
            $imagen->setImagenSeleccionada($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): self
    {
        if ($this->imagen->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getImagenSeleccionada() === $this) {
                $imagen->setImagenSeleccionada(null);
            }
        }

        return $this;
    }
}
