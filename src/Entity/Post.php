<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="postLike")
     */
    private $likesClientsList;

    public function __construct()
    {
        $this->likesClientsList = new ArrayCollection();
    }



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

    /**
     * @return Collection|Client[]
     */
    public function getLikesClientsList(): Collection
    {
        return $this->likesClientsList;
    }

    public function addLikesClientsList(Client $likesClientsList): self
    {
        if (!$this->likesClientsList->contains($likesClientsList)) {
            $this->likesClientsList[] = $likesClientsList;
            $likesClientsList->setPostLike($this);
        }

        return $this;
    }

    public function removeLikesClientsList(Client $likesClientsList): self
    {
        if ($this->likesClientsList->removeElement($likesClientsList)) {
            // set the owning side to null (unless already changed)
            if ($likesClientsList->getPostLike() === $this) {
                $likesClientsList->setPostLike(null);
            }
        }

        return $this;
    }

}
