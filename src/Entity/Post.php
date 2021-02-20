<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=PostType::class, inversedBy="posts")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="posts")
     */
    private $shop_related;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?PostType
    {
        return $this->type;
    }

    public function setType(?PostType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getShopRelated(): ?Shop
    {
        return $this->shop_related;
    }

    public function setShopRelated(?Shop $shop_related): self
    {
        $this->shop_related = $shop_related;

        return $this;
    }
}
