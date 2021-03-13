<?php


namespace App\Form\Model;


use App\Entity\Client;

class ClientDto
{
    private ?string $uid;
    private ?string $avatar;
    private ?string $nick;

    /**
     * ClientDto constructor.
     */
    public function __construct()
    {
    }

    public static function createEntityFromDto(ClientDto $clientDto) : Client
    {
        $client = new Client();

        $client->setUid($clientDto->getUid());
        $client->setNick($clientDto->getNick());
        $client->setAvatar($clientDto->getAvatar());
        return $client;
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

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * @param string|null $nick
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }



}