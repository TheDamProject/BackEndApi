<?php


namespace App\Form\Model;

use App\Entity\Shop;

class ShopDto
{

    private ?int $id = null;
    private ?string $name = "default";
    private ?Float $latitude;
    private ?Float $longitude;
    private ?string $address;
    private ?int $phone;
    private ?bool $isWhatsapp;
    private ?string $description;
    private ?string $logo;
    private ?string $category;
    private ?string $uid;


    public static function createDtoFromEntity(Shop $shop) : self
    {
        $dto  = new self();

        $dto->setName($shop->getName());
        $dto->setLatitude($shop->getLocation()->getLatitude());
        $dto->setLongitude($shop->getLocation()->getLongitude());
        $dto->setAddress($shop->getLocation()->getAddress());
        $dto->setPhone($shop->getShopData()->getPhone());
        $dto->setIsWhatsapp($shop->getShopData()->getIsWhatsapp());
        $dto->setDescription($shop->getShopData()->getDescription());
        $dto->setLogo($shop->getShopData()->getLogo());
        $dto->setCategory($shop->getShopCategory()->getCategory());
        $dto->setUid($shop->getUid());

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

    /**
     * @return string|null
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * @param string|null $uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid = $uid;
    }



}