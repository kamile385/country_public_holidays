<?php

namespace App\Entity;

use App\Repository\SupportedCountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupportedCountriesRepository::class)
 */
class SupportedCountries
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryCode;

    /**
     * @ORM\Column(type="array")
     */
    private $regions;

    /**
     * @ORM\Column(type="array")
     */
    private $holidayTypes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="array")
     */
    private $fromDate = [];

    /**
     * @ORM\Column(type="array")
     */
    private $toDate = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getRegions(): ?string
    {
        return $this->regions;
    }

    public function setRegions(string $regions): self
    {
        $this->regions = $regions;

        return $this;
    }

    public function getHolidayTypes(): ?string
    {
        return $this->holidayTypes;
    }

    public function setHolidayTypes(string $holidayTypes): self
    {
        $this->holidayTypes = $holidayTypes;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFromDate(): ?string
    {
        return $this->fromDate;
    }

    public function setFromDate(string $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?string
    {
        return $this->toDate;
    }

    public function setToDate(string $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }
}
