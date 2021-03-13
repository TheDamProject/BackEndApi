<?php


namespace App\Form\Model;

use App\Entity\Shop;

class ShopDto
{

    private ?int $id = null;
    private ?string $name = "default";
    private ?int $location_id = null ;
    private ?Float $latitude;
    private ?Float $longitude;
    private ?string $address;
    private ?string $id_google;
    private ?int $shopData_id = null;
    private ?int $phone;
    private ?bool $isWhatsapp;
    private ?string $description;
    private ?string $logo;
    private ?int $category_id = null ;
    private ?string $category;


    public static function createDtoFromEntity(Shop $shop) : self
    {
        $dto  = new self();

        $dto->setName($shop->getName());
        $dto->setLocationId($shop->getLocation()->getId());
        $dto->setLatitude($shop->getLocation()->getLatitude());
        $dto->setLongitude($shop->getLocation()->getLongitude());
        $dto->setAddress($shop->getLocation()->getAddress());
        $dto->setIdGoogle($shop->getLocation()->getIdGoogle());
        $dto->setShopDataId($shop->getShopData()->getId());
        $dto->setPhone($shop->getShopData()->getPhone());
        $dto->setIsWhatsapp($shop->getShopData()->getIsWhatsapp());
        $dto->setDescription($shop->getShopData()->getDescription());
        $dto->setLogo($shop->getShopData()->getLogo());
        $dto->setCategoryId($shop->getShopCategory()->getId());
        $dto->setCategory($shop->getShopCategory()->getCategory());

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getLocationId(): ?int
    {
        return $this->location_id;
    }

    /**
     * @param int|null $location_id
     */
    public function setLocationId(?int $location_id): void
    {
        $this->location_id = $location_id;
    }

    /**
     * @return Float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param Float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return Float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param Float|null $longitude
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

    /**
     * @return int|null
     */
    public function getShopDataId(): ?int
    {
        return $this->shopData_id;
    }

    /**
     * @param int|null $shopData_id
     */
    public function setShopDataId(?int $shopData_id): void
    {
        $this->shopData_id = $shopData_id;
    }

    /**
     * @return int|null
     */
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    /**
     * @param int|null $phone
     */
    public function setPhone(?int $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return bool|null
     */
    public function getIsWhatsapp(): ?bool
    {
        return $this->isWhatsapp;
    }

    /**
     * @param bool|null $isWhatsapp
     */
    public function setIsWhatsapp(?bool $isWhatsapp): void
    {
        $this->isWhatsapp = $isWhatsapp;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @param int|null $category_id
     */
    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }


}