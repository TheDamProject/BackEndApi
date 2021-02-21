<?php

namespace App\Entity;

use App\Repository\CommentaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaryRepository::class)
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
     * @ORM\Column(type="text")
     */
    private $contentComentary;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="comentaries")
     */
    private $shopComentaryRelated;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="clientComentaries")
     */
    private $clients;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="comentaries")
     */
    private $clientRelated;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentComentary(): ?string
    {
        return $this->contentComentary;
    }

    public function setContentComentary(string $contentComentary): self
    {
        $this->contentComentary = $contentComentary;

        return $this;
    }

    public function getShopComentaryRelated(): ?Shop
    {
        return $this->shopComentaryRelated;
    }

    public function setShopComentaryRelated(?Shop $shopComentaryRelated): self
    {
        $this->shopComentaryRelated = $shopComentaryRelated;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setClientComentaries($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getClientComentaries() === $this) {
                $client->setClientComentaries(null);
            }
        }

        return $this;
    }

    public function getClientRelated(): ?Client
    {
        return $this->clientRelated;
    }

    public function setClientRelated(?Client $clientRelated): self
    {
        $this->clientRelated = $clientRelated;

        return $this;
    }
}
