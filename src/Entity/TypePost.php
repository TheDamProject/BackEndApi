<?php

namespace App\Entity;

use App\Repository\TypePostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypePostRepository::class)
 */
class TypePost
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="typeOf")
     */
    private $postsOfThisType;

    public function __construct()
    {
        $this->postsOfThisType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostsOfThisType(): Collection
    {
        return $this->postsOfThisType;
    }

    public function addPostsOfThisType(Post $postsOfThisType): self
    {
        if (!$this->postsOfThisType->contains($postsOfThisType)) {
            $this->postsOfThisType[] = $postsOfThisType;
            $postsOfThisType->setTypeOf($this);
        }

        return $this;
    }

    public function removePostsOfThisType(Post $postsOfThisType): self
    {
        if ($this->postsOfThisType->removeElement($postsOfThisType)) {
            // set the owning side to null (unless already changed)
            if ($postsOfThisType->getTypeOf() === $this) {
                $postsOfThisType->setTypeOf(null);
            }
        }

        return $this;
    }
}
