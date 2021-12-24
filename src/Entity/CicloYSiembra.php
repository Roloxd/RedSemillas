<?php

namespace App\Entity;

use App\Repository\CicloYSiembraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CicloYSiembraRepository::class)
 */
class CicloYSiembra
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Variedad::class, inversedBy="cicloYSiembras")
     */
    private $variedad;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altitud;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zona;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ciclo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enero;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $febrero;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $marzo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $abril;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mayo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $junio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $julio;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $agosto;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $septiembre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $octubre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $noviembre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $diciembre;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAltitud(): ?string
    {
        return $this->altitud;
    }

    public function setAltitud(string $altitud): self
    {
        $this->altitud = $altitud;

        return $this;
    }

    public function getZona(): ?string
    {
        return $this->zona;
    }

    public function setZona(?string $zona): self
    {
        $this->zona = $zona;

        return $this;
    }

    public function getCiclo(): ?string
    {
        return $this->ciclo;
    }

    public function setCiclo(?string $ciclo): self
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    public function getEnero(): ?bool
    {
        return $this->enero;
    }

    public function setEnero(?bool $enero): self
    {
        $this->enero = $enero;

        return $this;
    }

    public function getFebrero(): ?bool
    {
        return $this->febrero;
    }

    public function setFebrero(?bool $febrero): self
    {
        $this->febrero = $febrero;

        return $this;
    }

    public function getMarzo(): ?bool
    {
        return $this->marzo;
    }

    public function setMarzo(?bool $marzo): self
    {
        $this->marzo = $marzo;

        return $this;
    }

    public function getAbril(): ?bool
    {
        return $this->abril;
    }

    public function setAbril(?bool $abril): self
    {
        $this->abril = $abril;

        return $this;
    }

    public function getMayo(): ?bool
    {
        return $this->mayo;
    }

    public function setMayo(?bool $mayo): self
    {
        $this->mayo = $mayo;

        return $this;
    }

    public function getJunio(): ?bool
    {
        return $this->junio;
    }

    public function setJunio(?bool $junio): self
    {
        $this->junio = $junio;

        return $this;
    }

    public function getJulio(): ?bool
    {
        return $this->julio;
    }

    public function setJulio(?bool $julio): self
    {
        $this->julio = $julio;

        return $this;
    }

    public function getAgosto(): ?bool
    {
        return $this->agosto;
    }

    public function setAgosto(?bool $agosto): self
    {
        $this->agosto = $agosto;

        return $this;
    }

    public function getSeptiembre(): ?bool
    {
        return $this->septiembre;
    }

    public function setSeptiembre(?bool $septiembre): self
    {
        $this->septiembre = $septiembre;

        return $this;
    }

    public function getOctubre(): ?bool
    {
        return $this->octubre;
    }

    public function setOctubre(?bool $octubre): self
    {
        $this->octubre = $octubre;

        return $this;
    }

    public function getNoviembre(): ?bool
    {
        return $this->noviembre;
    }

    public function setNoviembre(?bool $noviembre): self
    {
        $this->noviembre = $noviembre;

        return $this;
    }

    public function getDiciembre(): ?bool
    {
        return $this->diciembre;
    }

    public function setDiciembre(?bool $diciembre): self
    {
        $this->diciembre = $diciembre;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }
}
