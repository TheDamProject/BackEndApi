<?php


namespace App\form\Model;


use App\Entity\Client;

class ClientDto
{
    public int $id;
    public ?string $name;
    public ?string $surname;
    public ?string $email;
    public ?string $nick;
    public ?string $avatar;
    public ?string $uid_firebase;
    public ?array $commentaries;
    public ?array $shopsLikes;
    public ?array $postLikes;

    public static function createFromClient(Client $client) : self
    {
        $dto = New self();
        $dto->id = $client->getId();
        $dto->name = $client->getName();
        $dto->surname = $client->getSurname();
        $dto->email = $client->getEmail();
        $dto->nick = $client->getNick();
        $dto->avatar = $client->getAvatar();
        $dto->uid_firebase = $client->getUidFirebase();
        $dto->commentaries = $client->getComentaries();
        $dto->shopsLikes = $client->getLikeShop();
        $dto->postLikes = $client->getPostLike();

        return $dto;
    }
}

