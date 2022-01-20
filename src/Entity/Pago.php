<?php

namespace App\Entity;

use App\Repository\PagoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PagoRepository::class)
 */
class Pago
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_renovacion;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_pago;

    /**
     * @ORM\ManyToOne(targetEntity=Persona::class, inversedBy="pagos")
     */
    private $persona;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaRenovacion(): ?\DateTimeInterface
    {
        return $this->fecha_renovacion;
    }

    public function setFechaRenovacion(\DateTimeInterface $fecha_renovacion): self
    {
        $this->fecha_renovacion = $fecha_renovacion;

        return $this;
    }

    public function getFechaPago(): ?\DateTimeInterface
    {
        return $this->fecha_pago;
    }

    public function setFechaPago(\DateTimeInterface $fecha_pago): self
    {
        $this->fecha_pago = $fecha_pago;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        $this->persona = $persona;

        return $this;
    }
}
