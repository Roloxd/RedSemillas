<?php

namespace App\Entity;

use App\Repository\ImagenRepository;
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

    /**
     * @return Collection|ImagenSeleccionada[]
     */
    public function getImagenSeleccionadas(): Collection
    {
        return $this->ImagenSeleccionadas;
    }

    public function addImagenSeleccionada(ImagenSeleccionada $ImagenSeleccionada): self
    {
        if (!$this->ImagenSeleccionadas->contains($ImagenSeleccionada)) {
            $this->ImagenSeleccionadas[] = $ImagenSeleccionada;
            $ImagenSeleccionada->setImagen($this);
        }

        return $this;
    }

    public function removeImagen(ImagenSeleccionada $ImagenSeleccionada): self
    {
        if ($this->ImagenSeleccionadas->removeElement($ImagenSeleccionada)) {
            // set the owning side to null (unless already changed)
            if ($ImagenSeleccionada->getImagen() === $this) {
                $ImagenSeleccionada->setImagen(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
