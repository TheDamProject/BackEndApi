<?php

namespace App\Entity;

use App\Repository\ComentaryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentaryRepository::class)
 */
class Comentary
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="comentaries")
     */
    private $user_related;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="comentaries")
     */
    private $shop_related;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserRelated(): ?Users
    {
        return $this->user_related;
    }

    public function setUserRelated(?Users $user_related): self
    {
        $this->user_related = $user_related;

        return $this;
    }

    public function getShopRelated(): ?Shop
    {
        return $this->shop_related;
    }

    public function setShopRelated(?Shop $shop_related): self
    {
        $this->shop_related = $shop_related;

        return $this;
    }
}
