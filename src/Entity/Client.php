<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
     * @ORM\Column(type="string", length=255)
     */
    private $nick;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $uid_firebase;

    /**
     * @ORM\OneToMany(targetEntity=Comentary::class, mappedBy="clientRelated")
     */
    private $comentaries;


    /**
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="clientLikeShop")
     */
    private $likeShop;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="likesClientsList")
     */
    private $postLike;

    public function __construct()
    {
        $this->comentaries = new ArrayCollection();
        $this->likeShop = new ArrayCollection();
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

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

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
            $comentary->setClientRelated($this);
        }

        return $this;
    }

    public function removeComentary(Comentary $comentary): self
    {
        if ($this->comentaries->removeElement($comentary)) {
            // set the owning side to null (unless already changed)
            if ($comentary->getClientRelated() === $this) {
                $comentary->setClientRelated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getLikeShop(): Collection
    {
        return $this->likeShop;
    }

    public function addLikeShop(Shop $likeShop): self
    {
        if (!$this->likeShop->contains($likeShop)) {
            $this->likeShop[] = $likeShop;
            $likeShop->setClientLikeShop($this);
        }

        return $this;
    }

    public function removeLikeShop(Shop $likeShop): self
    {
        if ($this->likeShop->removeElement($likeShop)) {
            // set the owning side to null (unless already changed)
            if ($likeShop->getClientLikeShop() === $this) {
                $likeShop->setClientLikeShop(null);
            }
        }

        return $this;
    }

    public function getPostLike(): ?Post
    {
        return $this->postLike;
    }

    public function setPostLike(?Post $postLike): self
    {
        $this->postLike = $postLike;

        return $this;
    }
}
