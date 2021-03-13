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
    private ?int $type_id;
    private ?int $shopRelated_id;
    private ?string $image;
    private ?PostType $type;
    private ?Shop $shopRelated;

    public static function createEntityFromRequest(PostDto $postDto, PostType $type, Shop $shopRelated) : Post
    {
        $post = new Post();

        $post->setTitle($postDto->getTitle());
        $post->setContent($postDto->getContent());
        $post->setImage($postDto->getImage());
        $post->setType($type);
        $post->setShopRelated($shopRelated);

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
     * @return PostType|null
     */
    public function getType(): ?PostType
    {
        return $this->type;
    }

    /**
     * @param PostType|null $type
     */
    public function setType(?PostType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Shop|null
     */
    public function getShopRelated(): ?Shop
    {
        return $this->shopRelated;
    }

    /**
     * @param Shop|null $shopRelated
     */
    public function setShopRelated(?Shop $shopRelated): void
    {
        $this->shopRelated = $shopRelated;
    }

    /**
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    /**
     * @param int|null $type_id
     */
    public function setTypeId(?int $type_id): void
    {
        $this->type_id = $type_id;
    }

    /**
     * @return int|null
     */
    public function getShopRelatedId(): ?int
    {
        return $this->shopRelated_id;
    }

    /**
     * @param int|null $shopRelated_id
     */
    public function setShopRelatedId(?int $shopRelated_id): void
    {
        $this->shopRelated_id = $shopRelated_id;
    }



}