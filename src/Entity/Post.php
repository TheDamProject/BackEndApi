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
    private $post_content;

    /**
     * @ORM\Column(type="text")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="posts")
     */
    private $shop_id;

    /**
     * @ORM\ManyToOne(targetEntity=PostType::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="posts_likes")
     */
    private $users_likes;

    public function __construct()
    {
        $this->users_likes = new ArrayCollection();
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

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(string $post_content): self
    {
        $this->post_content = $post_content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getShopId(): ?Shop
    {
        return $this->shop_id;
    }

    public function setShopId(?Shop $shop_id): self
    {
        $this->shop_id = $shop_id;

        return $this;
    }

    public function getTypeId(): ?PostType
    {
        return $this->type_id;
    }

    public function setTypeId(?PostType $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersLikes(): Collection
    {
        return $this->users_likes;
    }

    public function addUsersLike(User $usersLike): self
    {
        if (!$this->users_likes->contains($usersLike)) {
            $this->users_likes[] = $usersLike;
        }

        return $this;
    }

    public function removeUsersLike(User $usersLike): self
    {
        $this->users_likes->removeElement($usersLike);

        return $this;
    }
}
