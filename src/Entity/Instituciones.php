<?php

namespace App\Entity;

use App\Repository\InstitucionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstitucionesRepository::class)
 */
class Instituciones
{
    // /**
    //  * @ORM\Id
    //  * @ORM\GeneratedValue
    //  * @ORM\Column(type="integer")
    //  */
    // private $id;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ACRONYM;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $OBSERVACIONES;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FULL_NAME;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TYPE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $STREET_POB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CITY_STATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ZIP_CODE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PHONE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FAX;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EMAIL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $URL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LATITUDE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $LONGITUDE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UPDATED_ON;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $V_INSTCODE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ISO3;

    /**
     * @ORM\OneToMany(targetEntity=Donante::class, mappedBy="codigoInstitutoRecolector")
     */
    private $donantes;

    /**
     * @ORM\OneToMany(targetEntity=Donante::class, mappedBy="codigoInstitutoMejoramiento")
     */
    private $donantesMejoramiento;

    public function __construct()
    {
        $this->donantes = new ArrayCollection();
        $this->donantesMejoramiento = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    // public function setINSTCODE(string $INSTCODE): self
    // {
    //     $this->INSTCODE = $INSTCODE;

    //     return $this;
    // }

    public function getACRONYM(): ?string
    {
        return $this->ACRONYM;
    }

    public function setACRONYM(?string $ACRONYM): self
    {
        $this->ACRONYM = $ACRONYM;

        return $this;
    }

    public function getOBSERVACIONES(): ?string
    {
        return $this->OBSERVACIONES;
    }

    public function setOBSERVACIONES(?string $OBSERVACIONES): self
    {
        $this->OBSERVACIONES = $OBSERVACIONES;

        return $this;
    }

    public function getFULLNAME(): ?string
    {
        return $this->FULL_NAME;
    }

    public function setFULLNAME(?string $FULL_NAME): self
    {
        $this->FULL_NAME = $FULL_NAME;

        return $this;
    }

    public function getTYPE(): ?string
    {
        return $this->TYPE;
    }

    public function setTYPE(?string $TYPE): self
    {
        $this->TYPE = $TYPE;

        return $this;
    }

    public function getSTREETPOB(): ?string
    {
        return $this->STREET_POB;
    }

    public function setSTREETPOB(?string $STREET_POB): self
    {
        $this->STREET_POB = $STREET_POB;

        return $this;
    }

    public function getCITYSTATE(): ?string
    {
        return $this->CITY_STATE;
    }

    public function setCITYSTATE(?string $CITY_STATE): self
    {
        $this->CITY_STATE = $CITY_STATE;

        return $this;
    }

    public function getZIPCODE(): ?string
    {
        return $this->ZIP_CODE;
    }

    public function setZIPCODE(?string $ZIP_CODE): self
    {
        $this->ZIP_CODE = $ZIP_CODE;

        return $this;
    }

    public function getPHONE(): ?string
    {
        return $this->PHONE;
    }

    public function setPHONE(?string $PHONE): self
    {
        $this->PHONE = $PHONE;

        return $this;
    }

    public function getFAX(): ?string
    {
        return $this->FAX;
    }

    public function setFAX(?string $FAX): self
    {
        $this->FAX = $FAX;

        return $this;
    }

    public function getEMAIL(): ?string
    {
        return $this->EMAIL;
    }

    public function setEMAIL(?string $EMAIL): self
    {
        $this->EMAIL = $EMAIL;

        return $this;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(?string $URL): self
    {
        $this->URL = $URL;

        return $this;
    }

    public function getLATITUDE(): ?string
    {
        return $this->LATITUDE;
    }

    public function setLATITUDE(?string $LATITUDE): self
    {
        $this->LATITUDE = $LATITUDE;

        return $this;
    }

    public function getLONGITUDE(): ?string
    {
        return $this->LONGITUDE;
    }

    public function setLONGITUDE(?string $LONGITUDE): self
    {
        $this->LONGITUDE = $LONGITUDE;

        return $this;
    }

    public function getUPDATEDON(): ?string
    {
        return $this->UPDATED_ON;
    }

    public function setUPDATEDON(?string $UPDATED_ON): self
    {
        $this->UPDATED_ON = $UPDATED_ON;

        return $this;
    }

    public function getVINSTCODE(): ?string
    {
        return $this->V_INSTCODE;
    }

    public function setVINSTCODE(?string $V_INSTCODE): self
    {
        $this->V_INSTCODE = $V_INSTCODE;

        return $this;
    }

    public function getISO3(): ?string
    {
        return $this->ISO3;
    }

    public function setISO3(?string $ISO3): self
    {
        $this->ISO3 = $ISO3;

        return $this;
    }

    /**
     * @return Collection|Donante[]
     */
    public function getDonantes(): Collection
    {
        return $this->donantes;
    }

    public function addDonante(Donante $donante): self
    {
        if (!$this->donantes->contains($donante)) {
            $this->donantes[] = $donante;
            $donante->setCodigoInstitutoRecolector($this);
        }

        return $this;
    }

    public function removeDonante(Donante $donante): self
    {
        if ($this->donantes->removeElement($donante)) {
            // set the owning side to null (unless already changed)
            if ($donante->getCodigoInstitutoRecolector() === $this) {
                $donante->setCodigoInstitutoRecolector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Donante[]
     */
    public function getDonantesMejoramiento(): Collection
    {
        return $this->donantesMejoramiento;
    }

    public function addDonantesMejoramiento(Donante $donantesMejoramiento): self
    {
        if (!$this->donantesMejoramiento->contains($donantesMejoramiento)) {
            $this->donantesMejoramiento[] = $donantesMejoramiento;
            $donantesMejoramiento->setCodigoInstitutoMejoramiento($this);
        }

        return $this;
    }

    public function removeDonantesMejoramiento(Donante $donantesMejoramiento): self
    {
        if ($this->donantesMejoramiento->removeElement($donantesMejoramiento)) {
            // set the owning side to null (unless already changed)
            if ($donantesMejoramiento->getCodigoInstitutoMejoramiento() === $this) {
                $donantesMejoramiento->setCodigoInstitutoMejoramiento(null);
            }
        }

        return $this;
    }
}
