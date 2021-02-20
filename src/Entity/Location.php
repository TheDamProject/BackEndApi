<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $id_google;

    /**
     * @ORM\OneToOne(targetEntity=Shop::class, mappedBy="location", cascade={"persist", "remove"})
     */
    private $shopLocation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getIdGoogle(): ?string
    {
        return $this->id_google;
    }

    public function setIdGoogle(?string $id_google): self
    {
        $this->id_google = $id_google;

        return $this;
    }

    public function getShopLocation(): ?Shop
    {
        return $this->shopLocation;
    }

    public function setShopLocation(?Shop $shopLocation): self
    {
        // unset the owning side of the relation if necessary
        if ($shopLocation === null && $this->shopLocation !== null) {
            $this->shopLocation->setLocation(null);
        }

        // set the owning side of the relation if necessary
        if ($shopLocation !== null && $shopLocation->getLocation() !== $this) {
            $shopLocation->setLocation($this);
        }

        $this->shopLocation = $shopLocation;

        return $this;
    }
}
