<?php


namespace App\Form\Model;


use App\Entity\Post;
use App\Entity\PostType;
use App\Entity\Shop;


class PostDto
{
    private ?int $id;
    private ?string $title;
    private ?string $content;
    private ?string $image;
    private ?string $typeValue;
    private ?string $shopUid;

    public static function createEntityFromRequest(PostDto $postDto, PostType $type, Shop $shopRelated) : Post
    {
        $post = new Post();

        $post->setTitle($postDto->getTitle());
        $post->setContent($postDto->getContent());
        $post->setImage($postDto->getImage());
        $post->setType($type);
        $post->setShopId($shopRelated);
        return $post;
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

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getTypeValue(): ?string
    {
        return $this->typeValue;
    }

    /**
     * @param string|null $typeValue
     */
    public function setTypeValue(?string $typeValue): void
    {
        $this->typeValue = $typeValue;
    }

    /**
     * @return string|null
     */
    public function getShopUid(): ?string
    {
        return $this->shopUid;
    }

    /**
     * @param string|null $shopUid
     */
    public function setShopUid(?string $shopUid): void
    {
        $this->shopUid = $shopUid;
    }


}