<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopRepository::class)
 */
class Shop
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
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="shopRelated")
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="shopsInLocation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\OneToOne(targetEntity=ShopData::class, mappedBy="shopRelated", cascade={"persist", "remove"})
     */
    private $shopData;

    /**
     * @ORM\ManyToOne(targetEntity=ShopCategory::class, inversedBy="shopsInCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shopCategory;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="shopRel")
     */
    private $postList;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->postList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setShopRelated($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getShopRelated() === $this) {
                $post->setShopRelated(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getShopData(): ?ShopData
    {
        return $this->shopData;
    }

    public function setShopData(ShopData $shopData): self
    {
        // set the owning side of the relation if necessary
        if ($shopData->getShopRelated() !== $this) {
            $shopData->setShopRelated($this);
        }

        $this->shopData = $shopData;

        return $this;
    }

    public function getShopCategory(): ?ShopCategory
    {
        return $this->shopCategory;
    }

    public function setShopCategory(?ShopCategory $shopCategory): self
    {
        $this->shopCategory = $shopCategory;

        return $this;
    }

    public function __toString():string
    {
        return (string) $this->getName();
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostList(): Collection
    {
        return $this->postList;
    }

    public function addPostList(Post $postList): self
    {
        if (!$this->postList->contains($postList)) {
            $this->postList[] = $postList;
            $postList->setShopRel($this);
        }

        return $this;
    }

    public function removePostList(Post $postList): self
    {
        if ($this->postList->removeElement($postList)) {
            // set the owning side to null (unless already changed)
            if ($postList->getShopRel() === $this) {
                $postList->setShopRel(null);
            }
        }

        return $this;
    }
}
