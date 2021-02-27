<?php


namespace App\Service;


use App\Entity\PostType;
use App\Form\Model\PostTypeDto;
use App\Repository\PostTypeRepository;
use Doctrine\ORM\EntityManagerInterface;


class PostTypeHandler
{
    private PostTypeRepository $postTypeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(PostTypeRepository $postTypeRepository , EntityManagerInterface $entityManager)
    {
        $this->postTypeRepository = $postTypeRepository;
        $this->entityManager = $entityManager;
    }

    public function existsPostType( PostTypeDto $postTypeDto ) : bool
    {
        $typeInRepo = $this->postTypeRepository->findBy(['type' => $postTypeDto->getType()]);
        if(!$typeInRepo){
            $result = false;
        }else{
            $result =  true;
        }

        return $result;
    }

    public function persistPostType( PostType $postType ) : PostType

    {

        $this->entityManager->persist($postType);
        $this->entityManager->flush();
        return $postType;
    }

    public function generateEntityFromDto(PostTypeDto $postTypeDto) : PostType
    {
        $postType = new PostType();
        $postType->setType($postTypeDto->getType());
        return $postType;
    }

    public function removePostTypeById(int $id): bool
    {
        $postType = $this->postTypeRepository->find($id);

        if($postType) {
            $this->entityManager->remove($postType);
            $this->entityManager->flush();
            return true;
        }else{
            return false;
        }

    }

}