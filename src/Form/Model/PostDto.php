<?php


namespace App\Form\Model;


use App\Entity\Post;
use App\Entity\PostType;
use App\Entity\Shop;


class PostDto
{
    public ?string $title;
    public ?string $content;
    public ?string $image;
    public ?PostType $type;
    public ?Shop $shopRelated;

    public static function createDtoFromEntity(Post $post) : self
    {
        $dto = new self();

        $dto->title = $post->getTitle();
        $dto->content = $post->getContent();
        $dto->image = $post->getImage();
        $dto->type = $post->getType();
        $dto->shopRelated = $post->getShopRelated();
        return $dto;
    }

}