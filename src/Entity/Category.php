<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="categoryRelated")
     */
    private $shopsCategoryRelated;

    public function __construct()
    {
        $this->shopsCategoryRelated = new ArrayCollection();
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
     * @return Collection|Shop[]
     */
    public function getShopsCategoryRelated(): Collection
    {
        return $this->shopsCategoryRelated;
    }

    public function addShopsCategoryRelated(Shop $shopsCategoryRelated): self
    {
        if (!$this->shopsCategoryRelated->contains($shopsCategoryRelated)) {
            $this->shopsCategoryRelated[] = $shopsCategoryRelated;
            $shopsCategoryRelated->setCategoryRelated($this);
        }

        return $this;
    }

    public function removeShopsCategoryRelated(Shop $shopsCategoryRelated): self
    {
        if ($this->shopsCategoryRelated->removeElement($shopsCategoryRelated)) {
            // set the owning side to null (unless already changed)
            if ($shopsCategoryRelated->getCategoryRelated() === $this) {
                $shopsCategoryRelated->setCategoryRelated(null);
            }
        }

        return $this;
    }
}
