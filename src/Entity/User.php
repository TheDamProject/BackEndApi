<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $uid_firebase;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nick;



    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="users_likes")
     */
    private $posts_likes;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, mappedBy="users_rated")
     */
    private $shops_rated;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, inversedBy="users")
     */
    private $subscriptions;

    public function __construct()
    {
        $this->posts_likes = new ArrayCollection();
        $this->shops_rated = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUidFirebase(): ?string
    {
        return $this->uid_firebase;
    }

    public function setUidFirebase(string $uid_firebase): self
    {
        $this->uid_firebase = $uid_firebase;

        return $this;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }


    /**
     * @return Collection|Post[]
     */
    public function getPostsLikes(): Collection
    {
        return $this->posts_likes;
    }

    public function addPostsLike(Post $postsLike): self
    {
        if (!$this->posts_likes->contains($postsLike)) {
            $this->posts_likes[] = $postsLike;
            $postsLike->addUsersLike($this);
        }

        return $this;
    }

    public function removePostsLike(Post $postsLike): self
    {
        if ($this->posts_likes->removeElement($postsLike)) {
            $postsLike->removeUsersLike($this);
        }

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShopsRated(): Collection
    {
        return $this->shops_rated;
    }

    public function addShopsRated(Shop $shopsRated): self
    {
        if (!$this->shops_rated->contains($shopsRated)) {
            $this->shops_rated[] = $shopsRated;
            $shopsRated->addUsersRated($this);
        }

        return $this;
    }

    public function removeShopsRated(Shop $shopsRated): self
    {
        if ($this->shops_rated->removeElement($shopsRated)) {
            $shopsRated->removeUsersRated($this);
        }

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Shop $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
        }

        return $this;
    }

    public function removeSubscription(Shop $subscription): self
    {
        $this->subscriptions->removeElement($subscription);

        return $this;
    }
}
