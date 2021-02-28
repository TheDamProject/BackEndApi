<?php


namespace App\Service;

use App\Entity\Location;
use App\Entity\Shop;
use App\Entity\ShopCategory;
use App\Entity\ShopData;
use App\Form\Model\CompleteShopDataDto;
use App\Form\Model\ShopDataDto;
use App\Form\Model\ShopDto;
use App\Repository\LocationRepository;
use App\Repository\ShopCategoryRepository;
use App\Repository\ShopDataRepository;
use App\Repository\ShopRepository;
use App\Utils\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Petstore30\Category;
use Psr\Log\LoggerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\Response;


class ShopHandlerService
{

    private ShopRepository $shopRepository;
    private LocationRepository $locationRepository;
    private ShopCategoryRepository $categoryRepository;
    private ShopDataRepository  $shopDataRepository;
    private EntityManagerInterface $entityManager;
    private ImageHandlerService $imageService;

    public function __construct
    (ShopDataRepository $shopDataRepository,
     LocationRepository $locationRepository,
     ShopCategoryRepository $categoryRepository,
     ShopRepository $repository,
     EntityManagerInterface $entityManager,
     ImageHandlerService $imageService)
    {
        $this->locationRepository = $locationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->shopRepository = $repository;
        $this->entityManager = $entityManager;
        $this->shopDataRepository =  $shopDataRepository;
        $this->imageService = $imageService;
    }

    public function createShopAndDataFromRequest(CompleteShopDataDto $completeShopDataDto)
    {


    }

    private function createCategoryIfNotExists(CompleteSHopDataDto $completeShopDataDto) : ShopCategory
    {
        $categoryRepo = $this->shopRepository->findBy(['shop_category_id' => $completeShopDataDto->getCategory()]);
        if(!$categoryRepo){
            $categoryRepo = new ShopCategory();
            $categoryRepo->setCategory($completeShopDataDto->getCategory());
            $this->persist($categoryRepo);
        }

        return  $categoryRepo;
    }

    private function createLocationIfNotExists(CompleteShopDataDto $completeShopDataDto): Location
    {
        $locationRepo = $this->locationRepository->findBy(['address' => $completeShopDataDto->getAddress()]);
        if(!$locationRepo) {
            $locationRepo = new Location();
            $locationRepo->setIdGoogle($completeShopDataDto->getIdGoogle());
            $locationRepo->setAddress($completeShopDataDto->getAddress());
            $locationRepo->setLongitude($completeShopDataDto->getLongitude());
            $locationRepo->setLatitude($completeShopDataDto->getLatitude());
            $this->persist($locationRepo);

        }
        return $locationRepo;

    }

    private function createShopDataIfNotExists(CompleteShopDataDto $completeShopDataDto)
    {
        $shopData = $this->shopDataRepository->findBy(['phone' => $completeShopDataDto->getPhone() , 'logo']);

    }


    private function createShopIfNotExists(CompleteShopDataDto $completeShopDataDto)
    {
        $shopRepo = $this->shopRepository->findBy(['name' => $completeShopDataDto->getName()]);
        if(!$shopRepo){
            $shopRepo = new Shop();
            $shopRepo->setName($completeShopDataDto->getName());

        }
    }

    public function  recoveryCompleteShopData(int $shopId) : ?CompleteShopDataDto
    {
        $completeData = new CompleteShopDataDto();

            $shop = $this->shopRepository->find($shopId);
            if(!$shop){
                return null;
            }

            $location = $shop->getLocation();
            $data = $shop-> getShopData();
            $category = $shop->getShopCategory();

            $completeData->setId($shop->getId());
            $completeData->setName($shop->getName());
            $completeData->setLatitude($location->getLatitude());
            $completeData->setLongitude($location->getLongitude());
            $completeData->setAddress($location->getAddress());
            $completeData->setIdGoogle($location->getIdGoogle());
            $completeData->setPhone($data->getPhone());
            $completeData->setIsWhatsapp($data->getIsWhatsapp());
            $completeData->setDescription($data->getDescription());
            $completeData->setPhone($data->getPhone());
            $completeData->setLogo($data->getLogo());
            $completeData->setCategory($category->getCategory());

        return $completeData;
    }

    public function deleteCompleteShopAndData($shopId): Response
    {
        $shop = $this->shopRepository->find($shopId);
        if(!$shop){
            return new Response('NO SHOP FOUND abort ' , Response::HTTP_NOT_MODIFIED);
        }

        $shopData = $this->shopDataRepository->find($shop->getShopData());
        if(!$shopData){
            return new Response('NO SHOP DATA FOUND abort ' , Response::HTTP_NOT_MODIFIED);
        }

        $this->imageService->deleteImage($shopData->getLogo());
        $this->entityManager->remove($shopData);
        $this->entityManager->remove($shop);
        $this->entityManager->flush();

        return new Response('Deleted Ok ' , Response::HTTP_OK);
    }

    private function persist($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }


}