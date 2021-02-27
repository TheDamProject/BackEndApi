<?php


namespace App\Service;

use App\Entity\Shop;
use App\Entity\ShopData;
use App\Form\Model\CompleteShopDataDto;
use App\Form\Model\ShopDataDto;
use App\Form\Model\ShopDto;
use App\Repository\LocationRepository;
use App\Repository\ShopCategoryRepository;
use App\Repository\ShopDataRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Psr\Log\LoggerInterface;
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

    public function createShopFromRequest(ShopDto $shopDto) : ?Shop
    {
        $shop = New Shop();

        $shop->setName($shopDto->getName());

        $location =  $this->locationRepository->find($shopDto->getLocationId());
        if(!$location){
            throw new EntityNotFoundException('NO LOCATION FOUND, Sorry!!');
        }else{
            $shop->setLocation($location);
        }

        $shopCategory = $this->categoryRepository->find($shopDto->getShopCategoryId());
        if(!$shopCategory){
            throw new EntityNotFoundException('NO CATEGORY FOUND, Sorry!!');
        }else{
            $shop->setShopCategory($shopCategory);
        }


        $shopData = ShopDataDto::createShopDataFromDto($shopDto->getDataCollection()[0]);

        $fileNameLogo = $this->imageService->saveImage($shopData->getLogo(),'shopLogos' );
        $shopData->setLogo($fileNameLogo);

        if($shopData){
            $shop->setShopData($shopData);

            $this->persistShopData($shopData);
            $this->persistShop($shop);
        }else{
            throw new Exception('NO Data CREATED, Sorry!!');
        }

        return $shop;

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

    public function deleteCompleteShopAndData($shopId): ?int
    {
        $shop = $this->shopRepository->find($shopId);
        if(!$shop){
            return null ;
        }

        $shopData = $this->shopDataRepository->find($shop->getShopData());
        if(!$shopData){
            return null;
        }

        $this->entityManager->remove($shopData);
        $this->entityManager->remove($shop);
        $this->entityManager->flush();

        return Response::HTTP_OK;
    }

    private function persistShopData(ShopData $shopData)
    {
       $this->entityManager->persist($shopData);
       $this->entityManager->flush();
    }

    private function persistShop(Shop $shop)
    {
        $this->entityManager->persist($shop);
        $this->entityManager->flush();
    }

}