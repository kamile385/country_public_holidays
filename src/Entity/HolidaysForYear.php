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

    public function getDate(): ?array
    {
        return $this->date;
    }

    public function setDate(array $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?array
    {
        return $this->name;
    }

    public function setName(array $name): self
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
