<?php

namespace App\Entity;

use App\Repository\CityWeatherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityWeatherRepository::class)
 */
class CityWeather
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
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cityCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minimumTemperature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $maximumTemperature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?string
    {
        return $this->cityCode;
    }

    public function setCityCode(?string $cityCode): self
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    public function getMinimumTemperature(): ?string
    {
        return $this->minimumTemperature;
    }

    public function setMinimumTemperature(?string $minimumTemperature): self
    {
        $this->minimumTemperature = $minimumTemperature;

        return $this;
    }

    public function getMaximumTemperature(): ?string
    {
        return $this->maximumTemperature;
    }

    public function setMaximumTemperature(?string $maximumTemperature): self
    {
        $this->maximumTemperature = $maximumTemperature;

        return $this;
    }
}
