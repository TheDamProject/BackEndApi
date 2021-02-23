<?php


namespace App\Form\Model;


class CompleteShopDataDto
{
    private ?string $name = "defaultName";
    private ?float $latitude = 0000.000;
    private ?float $longitude = 0000.111;
    private ?string $address  ="default address ";
    private ?string $id_google = "default IDD";
    private ?int $phone = 00000;
    private ?bool $isWhatsapp = false;
    private ?string $description = "defaultDescription";
    private ?string $logo = "defaultLogo";
    private ?string $category = "default category";
    private ?int $id ;

    /**
     * CompleteShopDataDto constructor.
     * @param string|null $name
     * @param float|null $latitude
     * @param float|null $longitude
     * @param string|null $address
     * @param string|null $id_google
     * @param int|null $phone
     * @param bool|null $isWhatsapp
     * @param string|null $description
     * @param string|null $logo
     * @param string|null $category
     */


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