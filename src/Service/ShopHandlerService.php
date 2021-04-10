<?php


namespace App\Service;

use App\Entity\Location;
use App\Entity\Shop;
use App\Entity\ShopCategory;
use App\Entity\ShopData;
use App\Form\Model\LocationDto;
use App\Form\Model\ShopDataDto;
use App\Form\Model\ShopDto;
use App\Form\Model\ShopsRequestDto;
use App\Repository\LocationRepository;
use App\Repository\ShopCategoryRepository;
use App\Repository\ShopDataRepository;
use App\Repository\ShopRepository;
use App\Utils\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;


class ShopHandlerService
{

    private ShopRepository $shopRepository;
    private LocationRepository $locationRepository;
    private ShopCategoryRepository $categoryRepository;
    private ShopDataRepository  $shopDataRepository;
    private EntityManagerInterface $entityManager;
    private ImageHandlerService $imageService;
    private UrlHelper $urlHelper;

    /**
     * ShopHandlerService constructor.
     * @param ShopRepository $shopRepository
     * @param LocationRepository $locationRepository
     * @param ShopCategoryRepository $categoryRepository
     * @param ShopDataRepository $shopDataRepository
     * @param EntityManagerInterface $entityManager
     * @param ImageHandlerService $imageService
     * @param UrlHelper $urlHelper
     */
    public function __construct
    (ShopRepository $shopRepository,
     LocationRepository $locationRepository,
     ShopCategoryRepository $categoryRepository,
     ShopDataRepository $shopDataRepository,
     EntityManagerInterface $entityManager,
     ImageHandlerService $imageService,
     UrlHelper $urlHelper)
    {
        $this->shopRepository = $shopRepository;
        $this->locationRepository = $locationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->shopDataRepository = $shopDataRepository;
        $this->entityManager = $entityManager;
        $this->imageService = $imageService;
        $this->urlHelper = $urlHelper;
    }


    public function getAllShops()
    {
        $shopsListDto = [];
        $shopsInRepository = $this->shopRepository->findAll();

        if ($shopsInRepository){
            foreach ($shopsInRepository as $shop){
                $shopDto = ShopDto::createDtoFromEntity($shop);
                array_push($shopsListDto ,$shopDto);
            }
            return $shopsListDto;
        }
        return new Response('NO SHOPS IN DATABASE ' ,Response::HTTP_NOT_FOUND);
    }


    public function getOneShopById(string $uid)
    {

        $shopFromDatabase = $this->shopRepository->findOneBy(['uid' => $uid]);

        if($shopFromDatabase) {
            $shopDto = ShopDto::createDtoFromEntity($shopFromDatabase);

        }else{
            return  new Response('Shop not found IN DATABASE ' ,Response::HTTP_NOT_FOUND);
        }

            if(!$shopDto){
                return  new Response('Shop not found IN DATABASE' ,Response::HTTP_NOT_FOUND);
            }
        return $shopDto;

    }


    public function createNewShop(ShopDto $shopDto)
    {

        $shop = new Shop();

        $shop->setName($shopDto->getName());
        $shop->setUid($shopDto->getUid());


        $shopFound = $this->shopRepository->findOneBy(
            [
                'uid' => $shop->getUid()
            ]);

        if(!$shopFound) {

            $shop->setLocation($this->handleLocation($shopDto));
            $shop->setShopCategory($this->handleCategory($shopDto));
            $shop->setShopData($this->handleShopData($shopDto, $shop));

            $this->persist($shop);
            $this->flushChanges();

            return ShopDto::createDtoFromEntity($shop);
        }else{
            return new Response('Shop has in database', Response::HTTP_NOT_MODIFIED);
        }

    }

    private function handleLocation(ShopDto $shopDto): Location
    {
        $locationFound = $this->locationRepository->findOneBy(
            [
                'latitude' => $shopDto->getLatitude(),
                'longitude' => $shopDto->getLongitude()
            ]);

        if (!$locationFound) {
            $location = LocationDto::createEntityFromShopDtoRequest($shopDto);
        } else {
            $location = $locationFound;
        }
       return $location;
    }

    private function handleCategory(ShopDto $shopDto): ShopCategory
    {
        $shopCategoryFound = $this->categoryRepository->findOneBy(
            [
                'category' => $shopDto->getCategory()
            ]);

        $category = new ShopCategory();

        if (!$shopCategoryFound) {
            $category->setCategory($shopDto->getCategory());
        } else {
            $category = $shopCategoryFound;
        }
        return $category;
    }

    private function handleShopData(ShopDto $shopDto, Shop $shop): ShopData
    {
        $shopDataFound = $this->shopDataRepository->findOneBy(
            [
                'phone' => $shopDto->getPhone(),
                'description' => $shopDto->getDescription(),
                'logo' => $shopDto->getLogo()
            ]);

        if (!$shopDataFound) {
            $fileNameLogo = $this->imageService->saveImage($shopDto->getLogo(), Constants::shopLogoDirectory);
            $shopDto->setLogo($this->urlHelper->getAbsoluteUrl(constants::pathOfImagesByDefault . $fileNameLogo));
            $shopData = ShopDataDto::createShopDataFromShopDtoRequest($shopDto, $shop);
        } else {
            $shopData = $shopDataFound;
        }
        return $shopData;
    }


    public function deleteOneShopById(string $uid): Response
    {
        $shop = $this->shopRepository->findOneBy(
        [
            'uid' => $uid
        ]);

        if($shop){

            if($this->removeOneBiId($shop->getShopData())){
                if($this->removeOneBiId($shop)){
                    $this->flushChanges();

                    foreach ($shop->getPosts() as $post){
                        $shop->removePost($post);
                        $this->removeOneBiId($post);
                    }

                    return  new Response('Shop and ShopData Deleted from Database' ,Response::HTTP_OK);
                }
            }
        }
        return  new Response('NOT DELETED, Shop width UID '. $uid .' not found' ,Response::HTTP_BAD_REQUEST);
    }



    private function persist($entity):int
    {
        try {
            $this->entityManager->persist($entity);
            $this->flushChanges();
            return Response::HTTP_OK;
        }catch (Exception $ex){
            return Response::HTTP_NOT_MODIFIED;
        }

    }

    private function removeOneBiId($entity): bool
    {
        try {
            $this->entityManager->remove($entity);
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    private function flushChanges(){
        $this->entityManager->flush();
    }



    public function getShopsAndPostsInRange(ShopsRequestDto $shopRequestDto)
    {
        $shopsList = $this->shopRepository->findAll();

        if($shopsList){
            return $shopsList;
        }
        return  new Response();
    }


}



























