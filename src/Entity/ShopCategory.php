<?php

namespace App\Entity;

use App\Repository\ShopCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopCategoryRepository::class)
 */
class ShopCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $category;

    /**
     * @ORM\OneToMany(targetEntity=Shop::class, mappedBy="shopCategory")
     */
    private ArrayCollection $shopsInCategory;

    public function __construct()
    {
        $this->shopsInCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShopsInCategory(): Collection
    {
        return $this->shopsInCategory;
    }

    public function addShopsInCategory(Shop $shopsInCategory): self
    {
        if (!$this->shopsInCategory->contains($shopsInCategory)) {
            $this->shopsInCategory[] = $shopsInCategory;
            $shopsInCategory->setShopCategory($this);
        }

        return $this;
    }

    public function removeShopsInCategory(Shop $shopsInCategory): self
    {
        if ($this->shopsInCategory->removeElement($shopsInCategory)) {
            // set the owning side to null (unless already changed)
            if ($shopsInCategory->getShopCategory() === $this) {
                $shopsInCategory->setShopCategory(null);
            }
        }

        return $this;
    }
}
