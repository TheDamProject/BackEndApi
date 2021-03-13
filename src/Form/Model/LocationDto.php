<?php


namespace App\Form\Model;


use App\Entity\Location;

class LocationDto
{
    private ?float $latitude;
    private ?float $longitude;
    private ?string $address;
    private ?string $id_google;


    public static function createDtoFromEntity(Location $location):self
    {
        $dto = new self();

        $dto->setLongitude($location->getLongitude());
        $dto->setLatitude($location->getLatitude());
        $dto->setAddress($location->getAddress());
        $dto->setIdGoogle($location->getIdGoogle());

        return $dto;
    }

    public static function createEntityFromDto(LocationDto $locationDto): Location
    {
        $location = new Location();

        $location->setLongitude($locationDto->getLongitude());
        $location->setLatitude($locationDto->getLatitude());
        $location->setAddress($locationDto->getAddress());
        $location->setIdGoogle($locationDto->getIdGoogle());

        return $location;
    }
    public static function createEntityFromShopDtoRequest(ShopDto $shopDto) : Location
    {
        $location = new Location();
        $location->setLongitude($shopDto->getLongitude());
        $location->setLatitude($shopDto->getLatitude());
        $location->setaddress($shopDto->getaddress());
        $location->setIdGoogle($shopDto->getIdGoogle());

        return $location;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getIdGoogle(): ?string
    {
        return $this->id_google;
    }

    /**
     * @param string|null $id_google
     */
    public function setIdGoogle(?string $id_google): void
    {
        $this->id_google = $id_google;
    }




}