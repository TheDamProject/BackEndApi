<?php


namespace App\Form\Model;




class LoginDto
{
    private ?string $uid;

    /**
     * LoginDto constructor.
     */
    public function __construct()
    {
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