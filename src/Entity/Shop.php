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
     * @ORM\OneToOne(targetEntity=DataShop::class, inversedBy="shopRelated", cascade={"persist", "remove"})
     */
    private $data;

    /**
     * @ORM\OneToOne(targetEntity=Location::class, inversedBy="shopLocation", cascade={"persist", "remove"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="shopsCategoryRelated")
     */
    private $categoryRelated;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="postOfShop")
     */
    private $postsOfTHisShop;

    /**
     * @ORM\OneToMany(targetEntity=Comentary::class, mappedBy="shopComentaryRelated")
     */
    private $comentaries;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="likeShop")
     */
    private $clientLikeShop;

    public function __construct()
    {
        $this->postsOfTHisShop = new ArrayCollection();
        $this->comentaries = new ArrayCollection();
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

    public function getData(): ?DataShop
    {
        return $this->data;
    }

    public function setData(?DataShop $data): self
    {
        $this->data = $data;

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

    public function getCategoryRelated(): ?Category
    {
        return $this->categoryRelated;
    }

    public function setCategoryRelated(?Category $categoryRelated): self
    {
        $this->categoryRelated = $categoryRelated;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostsOfTHisShop(): Collection
    {
        return $this->postsOfTHisShop;
    }

    public function addPostsOfTHisShop(Post $postsOfTHisShop): self
    {
        if (!$this->postsOfTHisShop->contains($postsOfTHisShop)) {
            $this->postsOfTHisShop[] = $postsOfTHisShop;
            $postsOfTHisShop->setPostOfShop($this);
        }

        return $this;
    }

    public function removePostsOfTHisShop(Post $postsOfTHisShop): self
    {
        if ($this->postsOfTHisShop->removeElement($postsOfTHisShop)) {
            // set the owning side to null (unless already changed)
            if ($postsOfTHisShop->getPostOfShop() === $this) {
                $postsOfTHisShop->setPostOfShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comentary[]
     */
    public function getComentaries(): Collection
    {
        return $this->comentaries;
    }

    public function addComentary(Comentary $comentary): self
    {
        if (!$this->comentaries->contains($comentary)) {
            $this->comentaries[] = $comentary;
            $comentary->setShopComentaryRelated($this);
        }

        return $this;
    }

    public function removeComentary(Comentary $comentary): self
    {
        if ($this->comentaries->removeElement($comentary)) {
            // set the owning side to null (unless already changed)
            if ($comentary->getShopComentaryRelated() === $this) {
                $comentary->setShopComentaryRelated(null);
            }
        }

        return $this;
    }

    public function getClientLikeShop(): ?Client
    {
        return $this->clientLikeShop;
    }

    public function setClientLikeShop(?Client $clientLikeShop): self
    {
        $this->clientLikeShop = $clientLikeShop;

        return $this;
    }
}
