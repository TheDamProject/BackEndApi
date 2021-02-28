<?php


namespace App\Service;

use App\Entity\Post;
use App\Form\Model\PostDto;
use App\Repository\PostTypeRepository;
use App\Repository\ShopRepository;
use App\Utils\Constants;
use Doctrine\DBAL\Exception as DoctrineException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PostHandlerService

{
      private EntityManagerInterface $entityManager;
      private PostTypeRepository $typeRepository;
      private ShopRepository  $shopRepository;
      private ImageHandlerService $imageService;

    /**
     * PostHandlerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param PostTypeRepository $typeRepository
     * @param ShopRepository $shopRepository
     * @param ImageHandlerService $imageService
     */
    public function __construct(EntityManagerInterface $entityManager, PostTypeRepository $typeRepository, ShopRepository $shopRepository, ImageHandlerService $imageService)
    {
        $this->entityManager = $entityManager;
        $this->typeRepository = $typeRepository;
        $this->shopRepository = $shopRepository;
        $this->imageService = $imageService;
    }


    public function persistPost(Post $post): bool
    {
        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
            return true;
        }catch (\Exception  $ex){
            return false;
    }

    }

    public function createPostFromRequest(PostDto $postDto): Post
    {
        $type = $this->typeRepository->find($postDto->getTypeId());
        $shop = $this->shopRepository->find($postDto->getShopRelatedId());
        $fileNameImage = $this->imageService->saveImage($postDto->getImage(),Constants::postImageDirectory );
        $postDto->setImage($fileNameImage);

        if(!$type || !$shop) throw new Exception('DATA NOT FOUND');

        return PostDto::createEntityFromRequest($postDto , $type , $shop);
    }

    public function deletePost(Post $post): Post
    {
        try{
            $this->imageService->deleteImage($post->getImage());
            $this->entityManager->remove($post);
            $this->entityManager->flush();
        }catch (DoctrineException $exception){
            throw new DoctrineException("Error try to remove Post");
        }
        return $post;
    }


}