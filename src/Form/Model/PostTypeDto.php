<?php


namespace App\Form\Model;


use App\Entity\PostType;

class PostTypeDto
{
    public ?int $id;
    public ?string $type;


    public static function createDtoFromEntity(PostType $postType) : self
    {
        $dto = new self();
        $dto->id = $postType->getId();
        $dto->type = $postType->getType();
        return $dto;
    }

}