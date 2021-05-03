<?php

namespace App\Entity;

use App\Repository\HolidaysForYearRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HolidaysForYearRepository::class)
 */
class HolidaysForYear
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $date;

    /**
     * @ORM\Column(type="array")
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     */
    private $holidayType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHolidayType(): ?array
    {
        return $this->holidayType;
    }

    public function setHolidayType(array $holidayType): self
    {
        $this->holidayType = $holidayType;

        return $this;
    }
}
