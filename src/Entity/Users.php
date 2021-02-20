<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $uid_firebase;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nick;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, inversedBy="subscriptors")
     */
    private $subscriptions;

    /**
     * @ORM\ManyToMany(targetEntity=Shop::class, inversedBy="users_vote")
     */
    private $votes;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class)
     */
    private $like_post;

    /**
     * @ORM\OneToMany(targetEntity=Comentary::class, mappedBy="user_related")
     */
    private $comentaries;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->votes = new ArrayCollection();
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

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUidFirebase(): ?string
    {
        return $this->uid_firebase;
    }

    public function setUidFirebase(?string $uid_firebase): self
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

    /**
     * @return Collection|Shop[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Shop $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
        }

        return $this;
    }

    public function removeVote(Shop $vote): self
    {
        $this->votes->removeElement($vote);

        return $this;
    }

    public function getLikePost(): ?Post
    {
        return $this->like_post;
    }

    public function setLikePost(?Post $like_post): self
    {
        $this->like_post = $like_post;

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
            $comentary->setUserRelated($this);
        }

        return $this;
    }

    public function removeComentary(Comentary $comentary): self
    {
        if ($this->comentaries->removeElement($comentary)) {
            // set the owning side to null (unless already changed)
            if ($comentary->getUserRelated() === $this) {
                $comentary->setUserRelated(null);
            }
        }

        return $this;
    }
}
