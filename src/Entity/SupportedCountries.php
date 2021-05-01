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

    public function getRegions(): ?array
    {
        return $this->regions;
    }

    public function setRegions(array $regions): self
    {
        $this->regions = $regions;

        return $this;
    }

    public function getHolidayTypes(): ?array
    {
        return $this->holidayTypes;
    }

    public function setHolidayTypes(array $holidayTypes): self
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

    public function getFromDate(): ?array
    {
        return $this->fromDate;
    }

    public function setFromDate(array $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?array
    {
        return $this->toDate;
    }

    public function setToDate(array $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }
}
