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
     * @ORM\ManyToOne(targetEntity=TypePost::class, inversedBy="postsOfThisType")
     */
    private $typeOf;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="postsOfTHisShop")
     */
    private $postOfShop;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="likePost")
     */
    private $likeOfClient;

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

    public function getTypeOf(): ?TypePost
    {
        return $this->typeOf;
    }

    public function setTypeOf(?TypePost $typeOf): self
    {
        $this->typeOf = $typeOf;

        return $this;
    }

    public function getPostOfShop(): ?Shop
    {
        return $this->postOfShop;
    }

    public function setPostOfShop(?Shop $postOfShop): self
    {
        $this->postOfShop = $postOfShop;

        return $this;
    }

    public function getLikeOfClient(): ?Client
    {
        return $this->likeOfClient;
    }

    public function setLikeOfClient(?Client $likeOfClient): self
    {
        $this->likeOfClient = $likeOfClient;

        return $this;
    }
}
