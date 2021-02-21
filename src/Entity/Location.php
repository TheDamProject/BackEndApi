<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $id_google;

    /**
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="location")
     */
    private $shopsInLocation;

    public function __construct()
    {
        $this->shopsInLocation = new ArrayCollection();
    }

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

    /**
     * @return Collection|Shop[]
     */
    public function getShopsInLocation(): Collection
    {
        return $this->shopsInLocation;
    }

    public function addShopsInLocation(Shop $shopsInLocation): self
    {
        if (!$this->shopsInLocation->contains($shopsInLocation)) {
            $this->shopsInLocation[] = $shopsInLocation;
            $shopsInLocation->setLocation($this);
        }

        return $this;
    }

    public function removeShopsInLocation(Shop $shopsInLocation): self
    {
        if ($this->shopsInLocation->removeElement($shopsInLocation)) {
            // set the owning side to null (unless already changed)
            if ($shopsInLocation->getLocation() === $this) {
                $shopsInLocation->setLocation(null);
            }
        }

        return $this;
    }
}
