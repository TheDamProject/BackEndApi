<?php


namespace App\Form\Model;


class ShopsRequestDto
{
    private ?int $range;
    private ?float $latitude;
    private ?float $longitude;

    /**
     * ShopsRequestDto constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getRange(): ?int
    {
        return $this->range;
    }

    /**
     * @param int|null $range
     */
    public function setRange(?int $range): void
    {
        $this->range = $range;
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



}