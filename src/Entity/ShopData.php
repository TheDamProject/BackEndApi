<?php

namespace App\Entity;

use App\Repository\ShopDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopDataRepository::class)
 */
class ShopData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isWhatsaap;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     */
    private $rate_average;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsWhatsaap(): ?bool
    {
        return $this->isWhatsaap;
    }

    public function setIsWhatsaap(bool $isWhatsaap): self
    {
        $this->isWhatsaap = $isWhatsaap;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRateAverage(): ?float
    {
        return $this->rate_average;
    }

    public function setRateAverage(float $rate_average): self
    {
        $this->rate_average = $rate_average;

        return $this;
    }
}
