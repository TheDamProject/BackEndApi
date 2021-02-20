<?php

namespace App\Entity;

use App\Repository\DataShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataShopRepository::class)
 */
class DataShop
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
    private $isWhatsapp;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rateAverage;

    /**
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="data")
     */
    private $shops;

    /**
     * @ORM\OneToOne(targetEntity=Shop::class, mappedBy="data", cascade={"persist", "remove"})
     */
    private $shopRelated;

    public function __construct()
    {
        $this->shops = new ArrayCollection();
    }

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
        return $this->rateAverage;
    }

    public function setRateAverage(?float $rateAverage): self
    {
        $this->rateAverage = $rateAverage;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
            $shop->setData($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getData() === $this) {
                $shop->setData(null);
            }
        }

        return $this;
    }

    public function getShopRelated(): ?Shop
    {
        return $this->shopRelated;
    }

    public function setShopRelated(?Shop $shopRelated): self
    {
        // unset the owning side of the relation if necessary
        if ($shopRelated === null && $this->shopRelated !== null) {
            $this->shopRelated->setData(null);
        }

        // set the owning side of the relation if necessary
        if ($shopRelated !== null && $shopRelated->getData() !== $this) {
            $shopRelated->setData($this);
        }

        $this->shopRelated = $shopRelated;

        return $this;
    }
}
