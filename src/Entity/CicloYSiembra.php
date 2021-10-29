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
    private $coordenadas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ciclo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $enero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $febrero;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $marzo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $abril;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mayo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $junio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $julio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $agosto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $septiembre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $octubre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noviembre;

    /**
     * @ORM\Column(type="integer", nullable=true)
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

    public function getCoordenadas(): ?string
    {
        return $this->coordenadas;
    }

    public function setCoordenadas(?string $coordenadas): self
    {
        $this->coordenadas = $coordenadas;

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

    public function getEnero(): ?int
    {
        return $this->enero;
    }

    public function setEnero(?int $enero): self
    {
        $this->enero = $enero;

        return $this;
    }

    public function getFebrero(): ?int
    {
        return $this->febrero;
    }

    public function setFebrero(?int $febrero): self
    {
        $this->febrero = $febrero;

        return $this;
    }

    public function getMarzo(): ?int
    {
        return $this->marzo;
    }

    public function setMarzo(?int $marzo): self
    {
        $this->marzo = $marzo;

        return $this;
    }

    public function getAbril(): ?int
    {
        return $this->abril;
    }

    public function setAbril(?int $abril): self
    {
        $this->abril = $abril;

        return $this;
    }

    public function getMayo(): ?int
    {
        return $this->mayo;
    }

    public function setMayo(?int $mayo): self
    {
        $this->mayo = $mayo;

        return $this;
    }

    public function getJunio(): ?int
    {
        return $this->junio;
    }

    public function setJunio(?int $junio): self
    {
        $this->junio = $junio;

        return $this;
    }

    public function getJulio(): ?int
    {
        return $this->julio;
    }

    public function setJulio(?int $julio): self
    {
        $this->julio = $julio;

        return $this;
    }

    public function getAgosto(): ?int
    {
        return $this->agosto;
    }

    public function setAgosto(?int $agosto): self
    {
        $this->agosto = $agosto;

        return $this;
    }

    public function getSeptiembre(): ?int
    {
        return $this->septiembre;
    }

    public function setSeptiembre(?int $septiembre): self
    {
        $this->septiembre = $septiembre;

        return $this;
    }

    public function getOctubre(): ?int
    {
        return $this->octubre;
    }

    public function setOctubre(?int $octubre): self
    {
        $this->octubre = $octubre;

        return $this;
    }

    public function getNoviembre(): ?int
    {
        return $this->noviembre;
    }

    public function setNoviembre(?int $noviembre): self
    {
        $this->noviembre = $noviembre;

        return $this;
    }

    public function getDiciembre(): ?int
    {
        return $this->diciembre;
    }

    public function setDiciembre(?int $diciembre): self
    {
        $this->diciembre = $diciembre;

        return $this;
    }
}
