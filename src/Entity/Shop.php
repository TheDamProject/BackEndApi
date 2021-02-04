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
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="shop", orphanRemoval=true)
     */
    private $location_id;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="shop", orphanRemoval=true)
     */
    private $category_id;

    /**
     * @ORM\OneToMany(targetEntity=ShopData::class, mappedBy="shop", orphanRemoval=true)
     */
    private $data_id;

    /**
     * @ORM\OneToMany(targetEntity=Comentary::class, mappedBy="shop_id")
     */
    private $comentaries;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="shop_id")
     */
    private $posts;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="shop_subscriptions")
     */
    private $subscriptors;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="shops_rated")
     */
    private $users_rated;

    public function __construct()
    {
        $this->location_id = new ArrayCollection();
        $this->category_id = new ArrayCollection();
        $this->data_id = new ArrayCollection();
        $this->comentaries = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->subscriptors = new ArrayCollection();
        $this->users_rated = new ArrayCollection();
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
     * @return Collection|Location[]
     */
    public function getLocationId(): Collection
    {
        return $this->location_id;
    }

    public function addLocationId(Location $locationId): self
    {
        if (!$this->location_id->contains($locationId)) {
            $this->location_id[] = $locationId;
            $locationId->setShop($this);
        }

        return $this;
    }

    public function removeLocationId(Location $locationId): self
    {
        if ($this->location_id->removeElement($locationId)) {
            // set the owning side to null (unless already changed)
            if ($locationId->getShop() === $this) {
                $locationId->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategoryId(): Collection
    {
        return $this->category_id;
    }

    public function addCategoryId(Category $categoryId): self
    {
        if (!$this->category_id->contains($categoryId)) {
            $this->category_id[] = $categoryId;
            $categoryId->setShop($this);
        }

        return $this;
    }

    public function removeCategoryId(Category $categoryId): self
    {
        if ($this->category_id->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getShop() === $this) {
                $categoryId->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShopData[]
     */
    public function getDataId(): Collection
    {
        return $this->data_id;
    }

    public function addDataId(ShopData $dataId): self
    {
        if (!$this->data_id->contains($dataId)) {
            $this->data_id[] = $dataId;
            $dataId->setShop($this);
        }

        return $this;
    }

    public function removeDataId(ShopData $dataId): self
    {
        if ($this->data_id->removeElement($dataId)) {
            // set the owning side to null (unless already changed)
            if ($dataId->getShop() === $this) {
                $dataId->setShop(null);
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
            $comentary->setShopId($this);
        }

        return $this;
    }

    public function removeComentary(Comentary $comentary): self
    {
        if ($this->comentaries->removeElement($comentary)) {
            // set the owning side to null (unless already changed)
            if ($comentary->getShopId() === $this) {
                $comentary->setShopId(null);
            }
        }

        return $this;
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
            $post->setShopId($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getShopId() === $this) {
                $post->setShopId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSubscriptors(): Collection
    {
        return $this->subscriptors;
    }

    public function addSubscriptor(User $subscriptor): self
    {
        if (!$this->subscriptors->contains($subscriptor)) {
            $this->subscriptors[] = $subscriptor;
        }

        return $this;
    }

    public function removeSubscriptor(User $subscriptor): self
    {
        $this->subscriptors->removeElement($subscriptor);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersRated(): Collection
    {
        return $this->users_rated;
    }

    public function addUsersRated(User $usersRated): self
    {
        if (!$this->users_rated->contains($usersRated)) {
            $this->users_rated[] = $usersRated;
        }

        return $this;
    }

    public function removeUsersRated(User $usersRated): self
    {
        $this->users_rated->removeElement($usersRated);

        return $this;
    }
}
