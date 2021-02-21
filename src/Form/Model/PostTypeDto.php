<?php


namespace App\Form\Model;


use App\Entity\PostType;

class PostTypeDto
{

    public ?string $type;


    public static function createDtoFromEntity(PostType $postType) : self
    {
        $dto = new self();

        $dto->type = $postType->getType();
        return $dto;
    }

}