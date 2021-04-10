<?php


namespace App\Form\Model;


use App\Entity\Location;

class LocationDto
{
    private ?float $latitude;
    private ?float $longitude;
    private ?string $address;


    public static function createEntityFromShopDtoRequest(ShopDto $shopDto) : Location
    {
        $location = new Location();
        $location->setLongitude($shopDto->getLongitude());
        $location->setLatitude($shopDto->getLatitude());
        $location->setaddress($shopDto->getaddress());

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



}