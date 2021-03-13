<?php


namespace App\Form\Model;


class ShopCreationInformerModel
{
    private ?int $location_created = 0;
    private ?int $shopData_created = 0 ;
    private ?int $category_created = 0 ;
    private ?int $shop_created = 0 ;

    /**
     * @return int
     */
    public function getLocationCreated(): int
    {
        return $this->location_created;
    }

    /**
     * @param int $location_created
     */
    public function setLocationCreated(int $location_created): void
    {
        $this->location_created = $location_created;
    }

    /**
     * @return int
     */
    public function getShopDataCreated(): int
    {
        return $this->shopData_created;
    }

    /**
     * @param int $shopData_created
     */
    public function setShopDataCreated(int $shopData_created): void
    {
        $this->shopData_created = $shopData_created;
    }

    /**
     * @return int
     */
    public function getCategoryCreated(): int
    {
        return $this->category_created;
    }

    /**
     * @param int $category_created
     */
    public function setCategoryCreated(int $category_created): void
    {
        $this->category_created = $category_created;
    }

    /**
     * @return int
     */
    public function getShopCreated(): int
    {
        return $this->shop_created;
    }

    /**
     * @param int $shop_created
     */
    public function setShopCreated(int $shop_created): void
    {
        $this->shop_created = $shop_created;
    }



}