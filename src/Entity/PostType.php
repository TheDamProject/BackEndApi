<?php

namespace App\Entity;

use App\Repository\PostTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostTypeRepository::class)
 */
class PostType
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="type" , cascade={"persist"})
     */
    private $postByType;

    public function __construct()
    {
        $this->postByType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostByType(): Collection
    {
        return $this->postByType;
    }

    public function addPostByType(Post $postByType): self
    {
        if (!$this->postByType->contains($postByType)) {
            $this->postByType[] = $postByType;
            $postByType->setType($this);
        }

        return $this;
    }

    public function removePostByType(Post $postByType): self
    {
        if ($this->postByType->removeElement($postByType)) {
            // set the owning side to null (unless already changed)
            if ($postByType->getType() === $this) {
                $postByType->setType(null);
            }
        }

        return $this;
    }
}
