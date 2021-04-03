<?php


namespace App\Service;

use App\Entity\Shop;
use App\Entity\ShopCategory;
use App\Form\Model\LocationDto;
use App\Form\Model\ShopCreationInformerModel;
use App\Form\Model\ShopDataDto;
use App\Form\Model\ShopDto;
use App\Form\Model\ShopsRequestDto;
use App\Repository\LocationRepository;
use App\Repository\ShopCategoryRepository;
use App\Repository\ShopDataRepository;
use App\Repository\ShopRepository;
use App\Utils\Constants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
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
    public function __construct(ShopRepository $shopRepository, LocationRepository $locationRepository, ShopCategoryRepository $categoryRepository, ShopDataRepository $shopDataRepository, EntityManagerInterface $entityManager, ImageHandlerService $imageService, UrlHelper $urlHelper)
    {
        $this->shopRepository = $shopRepository;
        $this->locationRepository = $locationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->shopDataRepository = $shopDataRepository;
        $this->entityManager = $entityManager;
        $this->imageService = $imageService;
        $this->urlHelper = $urlHelper;
    }


    public function getAllShops() : ArrayCollection
    {
        $shopsListDto = new ArrayCollection();
        $shopsInRepository = $this->shopRepository->findAll();

        foreach ($shopsInRepository as $shop){
            $shopDto = ShopDto::createDtoFromEntity($shop);
            $shopsListDto->add($shopDto);
        }

        return $shopsListDto;

    }


    public function getOneShopById(int $id) : ShopDto
    {
        $shopDto =  ShopDto::createDtoFromEntity($this->shopRepository->find($id));

        if(!$shopDto){
            throw new Exception('NO SHOP FOUND');
        }
        return $shopDto;
    }


    public function createNewShop(ShopDto $shopDto) : ShopCreationInformerModel
    {
        $result = new ShopCreationInformerModel();

        $shop = new Shop();
        $shop->setName($shopDto->getName());
        $shop->setUid($shopDto->getUid());

        $this->handleLocation($shopDto, $result, $shop);
        $this->handleCategory($shopDto, $result, $shop);
        $this->handleShopData($shopDto, $shop, $result);

        $shopFound = $this->shopRepository->findOneBy(['name' =>$shop->getName() , 'location' => $shop->getLocation()]);
        if(!$shopFound)
        {
            $result->setShopCreated($this->persist($shop));

        }else{
            $result->setShopCreated(Response::HTTP_NOT_MODIFIED);
        }

        return $result;
    }

    public function deleteOneShopById(int $id): bool
    {
        $shop = $this->shopRepository->find($id);

        if($this->removeOneBiId($shop->getShopData())){
            if($this->removeOneBiId($shop)){
                $this->flushChanges();
                return true;
            }
        }
        return false;
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

    /**
     * @param ShopDto $shopDto
     * @param ShopCreationInformerModel $result
     * @param Shop $shop
     */
    public function handleLocation(ShopDto $shopDto, ShopCreationInformerModel $result, Shop $shop): void
    {
            $locationFound = $this->locationRepository->findOneBy(
                ['latitude' => $shopDto->getLatitude(),
                    'longitude' => $shopDto->getLongitude()]);

            if (!$locationFound) {
                $location = LocationDto::createEntityFromShopDtoRequest($shopDto);
                $result->setLocationCreated($this->persist($location));
            } else {
                $location = $locationFound;
                $result->setLocationCreated(Response::HTTP_NOT_MODIFIED);
            }
            $shop->setLocation($location);

    }

    /**
     * @param ShopDto $shopDto
     * @param ShopCreationInformerModel $result
     * @param Shop $shop
     */
    public function handleCategory(ShopDto $shopDto, ShopCreationInformerModel $result, Shop $shop): void
    {

        $shopCategoryFound = $this->categoryRepository->findOneBy(
            ['category' => $shopDto->getCategory()]);

        $category = new ShopCategory();

        if (!$shopCategoryFound) {
            $category->setCategory($shopDto->getCategory());
            $result->setCategoryCreated($this->persist($category));
        } else {
            $category = $shopCategoryFound;
            $result->setCategoryCreated(Response::HTTP_NOT_MODIFIED);

        }
        $shop->setShopCategory($category);

    }

    /**
     * @param ShopDto $shopDto
     * @param Shop $shop
     * @param ShopCreationInformerModel $result
     */
    public function handleShopData(ShopDto $shopDto, Shop $shop, ShopCreationInformerModel $result): void
    {

        $shopDataFound = $this->shopDataRepository->findOneBy(
               ['phone' => $shopDto->getPhone(),
                'description' => $shopDto->getDescription(),
                'logo' => $shopDto->getLogo()]);
        if (!$shopDataFound) {
            $fileNameLogo = $this->imageService->saveImage($shopDto->getLogo(), Constants::shopLogoDirectory);
            $shopDto->setLogo($this->urlHelper->getAbsoluteUrl(constants::pathOfImagesByDefault . $fileNameLogo));
            $shopData = ShopDataDto::createShopDataFromShopDtoRequest($shopDto, $shop);
            $result->setShopDataCreated($this->persist($shopData));
        } else {
            $shopData = $shopDataFound;
            $result->setShopDataCreated(Response::HTTP_NOT_MODIFIED);
        }

        $shop->setShopData($shopData);


    }

    public function getShopsAndPostsInRange(ShopsRequestDto $shopRequestDto)
    {
        $shopsList = $this->shopRepository->findAll();

        if($shopsList){
            return $shopsList;
        }
        return  Response::HTTP_NOT_FOUND;
    }
}



























