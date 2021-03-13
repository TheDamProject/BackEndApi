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
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isWhatsapp;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $logo;

    /**
     * @ORM\OneToOne(targetEntity=Shop::class, inversedBy="shopData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Shop $shopRelated;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getShopRelated(): ?Shop
    {
        return $this->shopRelated;
    }

    public function setShopRelated(Shop $shopRelated): self
    {
        $this->shopRelated = $shopRelated;

        return $this;
    }
}
