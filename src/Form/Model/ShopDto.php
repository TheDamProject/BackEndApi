<?php


namespace App\Form\Model;



use App\Entity\ShopCategory;


class ShopDto
{
    private ?string $name;
    private ?int $locationId;
    private ?int $shopCategoryId;
    private ?array $data_collection = [];


    /**
     * @return array|null
     */
    public function getDataCollection(): ?array
    {
        return $this->data_collection;
    }

    /**
     * @param array|null $data_collection
     */
    public function setDataCollection(?array $data_collection): void
    {
        $this->data_collection = $data_collection;
    }




    /**
     * @return int|null
     */
    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * @param int|null $locationId
     */
    public function setLocationId(?int $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * @return int|null
     */
    public function getShopCategoryId(): ?int
    {
        return $this->shopCategoryId;
    }

    /**
     * @param int|null $shopCategoryId
     */
    public function setShopCategoryId(?int $shopCategoryId): void
    {
        $this->shopCategoryId = $shopCategoryId;
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
     * @param ShopCategory|null $shopCategory
     */
    public function setShopCategory(?ShopCategory $shopCategory): void
    {
        $this->shopCategory = $shopCategory;
    }



}