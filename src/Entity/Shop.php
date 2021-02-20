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
     * @ORM\ManyToOne(targetEntity=ShopData::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="shops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="shop_related")
     */
    private $posts;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="subscriptions")
     */
    private $subscriptors;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="votes")
     */
    private $users_vote;

    /**
     * @ORM\OneToMany(targetEntity=Comentary::class, mappedBy="shop_related")
     */
    private $comentaries;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->subscriptors = new ArrayCollection();
        $this->users_vote = new ArrayCollection();
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

    public function getData(): ?ShopData
    {
        return $this->data;
    }

    public function setData(?ShopData $data): self
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection|Users[]
     */
    public function getSubscriptors(): Collection
    {
        return $this->subscriptors;
    }

    public function addSubscriptor(Users $subscriptor): self
    {
        if (!$this->subscriptors->contains($subscriptor)) {
            $this->subscriptors[] = $subscriptor;
            $subscriptor->addSubscription($this);
        }

        return $this;
    }

    public function removeSubscriptor(Users $subscriptor): self
    {
        if ($this->subscriptors->removeElement($subscriptor)) {
            $subscriptor->removeSubscription($this);
        }

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsersVote(): Collection
    {
        return $this->users_vote;
    }

    public function addUsersVote(Users $usersVote): self
    {
        if (!$this->users_vote->contains($usersVote)) {
            $this->users_vote[] = $usersVote;
            $usersVote->addVote($this);
        }

        return $this;
    }

    public function removeUsersVote(Users $usersVote): self
    {
        if ($this->users_vote->removeElement($usersVote)) {
            $usersVote->removeVote($this);
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
            $comentary->setShopRelated($this);
        }

        return $this;
    }

    public function removeComentary(Comentary $comentary): self
    {
        if ($this->comentaries->removeElement($comentary)) {
            // set the owning side to null (unless already changed)
            if ($comentary->getShopRelated() === $this) {
                $comentary->setShopRelated(null);
            }
        }

        return $this;
    }
}
