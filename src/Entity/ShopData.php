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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isWhatsapp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float", nullable=true)
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

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsWhatsapp(): ?bool
    {
        return $this->isWhatsapp;
    }

    public function setIsWhatsapp(bool $isWhatsapp): self
    {
        $this->isWhatsapp = $isWhatsapp;

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

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRateAverage(): ?float
    {
        return $this->rate_average;
    }

    public function setRateAverage(?float $rate_average): self
    {
        $this->rate_average = $rate_average;

        return $this;
    }
}
