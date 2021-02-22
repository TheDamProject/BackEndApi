<?php


namespace App\Form\Model;


use App\Entity\PostType;

class PostTypeDto
{
    private ?int $id;
    private ?string $type;


    public static function createDtoFromEntity(PostType $postType) : self
    {
        $dto = new self();
        $dto->id = $postType->getId();
        $dto->type = $postType->getType();
        return $dto;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }



}