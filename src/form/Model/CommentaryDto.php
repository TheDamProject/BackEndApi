<?php


namespace App\form\Model;


use App\Entity\Comentary;

class CommentaryDto
{
    public ?String $contentCommentary;
    public ?array $shopCommentaryRelated;
    public ?array $clientRelated;


    public function __construct()
    {

        $this->shopCommentaryRelated = [];
        $this->clientRelated = [];

    }

    public static function  createFromCommentary(Comentary $commentary) : self
    {
        $dto = New self();

        $dto->contentCommentary = $commentary->getContentComentary();
        $dto->clientRelated = $commentary->getClients();
        $dto->shopCommentaryRelated = $commentary->getShopComentaryRelated();

        return $dto;
    }
}