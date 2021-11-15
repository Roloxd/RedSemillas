<?php

namespace App\Entity;

use App\Repository\ImagenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagenRepository::class)
 */
class Imagen
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
    private $url;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $credito;

    /**
     * @ORM\OneToMany(targetEntity=ImagenSeleccionada::class, mappedBy="imagen")
     */
    private $imagenSeleccionadas;

    /**
     * @ORM\Column(type="boolean")
     */
    private $principal;

    public function __construct()
    {
        $this->imagenSeleccionadas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getCredito(): ?string
    {
        return $this->credito;
    }

    public function setCredito(?string $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    /**
     * @return Collection|ImagenSeleccionada[]
     */
    public function getImagenSeleccionadas(): Collection
    {
        return $this->imagenSeleccionadas;
    }

    public function addImagenSeleccionada(ImagenSeleccionada $imagenSeleccionada): self
    {
        if (!$this->imagenSeleccionadas->contains($imagenSeleccionada)) {
            $this->imagenSeleccionadas[] = $imagenSeleccionada;
            $imagenSeleccionada->setImagen($this);
        }

        return $this;
    }

    public function removeImagenSeleccionada(ImagenSeleccionada $imagenSeleccionada): self
    {
        if ($this->imagenSeleccionadas->removeElement($imagenSeleccionada)) {
            // set the owning side to null (unless already changed)
            if ($imagenSeleccionada->getImagen() === $this) {
                $imagenSeleccionada->setImagen(null);
            }
        }

        return $this;
    }

    public function getPrincipal(): ?bool
    {
        return $this->principal;
    }

    public function setPrincipal(bool $principal): self
    {
        $this->principal = $principal;

        return $this;
    }
}
