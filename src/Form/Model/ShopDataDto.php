<?php


namespace App\Form\Model;


use App\Entity\Shop;
use App\Entity\ShopData;

class ShopDataDto
{
    private ?int $phone;
    private ?bool $isWhatsapp;
    private ?string $description;
    private ?string $logo;
    private ?int $id;


    public static function createShopDataFromDto(self $shopDataDto) : ShopData
    {
        $shopData = new ShopData();

        $shopData->setPhone($shopDataDto->getPhone());
        $shopData->setIsWhatsapp($shopDataDto->getIsWhatsapp());
        $shopData->setDescription($shopDataDto->getDescription());
        $shopData->setLogo($shopDataDto->getLogo());

        return $shopData;
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



}