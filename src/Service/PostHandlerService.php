<?php


namespace App\Service;

use App\Entity\Post;
use App\Entity\PostType;
use App\Form\Model\PostDto;
use App\Repository\PostRepository;
use App\Repository\PostTypeRepository;
use App\Repository\ShopRepository;
use App\Utils\Constants;
use Doctrine\DBAL\Exception as DoctrineException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;

class PostHandlerService

{
    private EntityManagerInterface $entityManager;
    private PostTypeRepository $typeRepository;
    private ShopRepository  $shopRepository;
    private ImageHandlerService $imageService;
    private PostRepository  $postRepository;
    private UrlHelper $urlHelper;



    /**
     * PostHandlerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param PostTypeRepository $typeRepository
     * @param ShopRepository $shopRepository
     * @param ImageHandlerService $imageService
     * @param UrlHelper $urlhelper
     */
    public function __construct(EntityManagerInterface $entityManager,PostRepository  $postRepository, PostTypeRepository $typeRepository, ShopRepository $shopRepository, ImageHandlerService $imageService, UrlHelper $urlhelper)
    {
        $this->entityManager = $entityManager;
        $this->typeRepository = $typeRepository;
        $this->shopRepository = $shopRepository;
        $this->imageService = $imageService;
        $this->urlHelper = $urlhelper;
        $this->postRepository =  $postRepository;
    }


    public function getAllPosts()
    {
        return $this->postRepository->findAll();
    }


    public function createPostFromRequest(PostDto $postDto)
    {

        $typeFromDb = $this->typeRepository->findOneBy(['type' => $postDto->getTypeValue()] ) ;

        $type = new PostType();

        if (!$typeFromDb) {
            $type->setType($postDto->getTypeValue());
            $this->entityManager->persist($type);
            $this->entityManager->flush();
            $typeFromDb = $type;
        }

        $shop = $this->shopRepository->find($this->shopRepository->findOneBy(['uid' => $postDto->getShopUid()] ));

        if(!$shop) {
            return new Response(null,  Response::HTTP_NOT_FOUND);
        }

        $fileNameImage = $this->imageService->saveImage($postDto->getImage(),Constants::postImageDirectory );
        $postDto->setImage($this->urlHelper->getAbsoluteUrl(constants::pathOfImagesByDefault. $fileNameImage));
        $postCreated = PostDto::createEntityFromRequest($postDto , $typeFromDb, $shop);
        if($this->persistPost($postCreated)){
            return $postCreated;
        }

        return new Response(null,  Response::HTTP_BAD_REQUEST);
    }

    public function persistPost(Post $post): bool
    {
        try {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
            return true;
        }catch (Exception  $ex){
            return false;
        }
    }

    public function deletePost(int $postId)
    {

        try{
            $post =  $this->postRepository->find($postId);

            if($post){
                $this->imageService->deleteImage($post->getImage());
                $this->entityManager->remove($post);
                $this->entityManager->flush();
                return $post;
            }
            return  new Response(null,  Response::HTTP_NOT_FOUND);

        }catch (Exception $exception){
            return new Response(null,  Response::HTTP_NOT_MODIFIED);
        }
    }



}