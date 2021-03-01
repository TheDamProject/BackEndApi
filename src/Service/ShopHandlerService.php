<?php


namespace App\Service;

use App\Entity\Shop;
use App\Entity\ShopCategory;
use App\Form\Model\LocationDto;
use App\Form\Model\ShopCreationInformerModel;
use App\Form\Model\ShopDataDto;
use App\Form\Model\ShopDto;
use App\Repository\LocationRepository;
use App\Repository\ShopCategoryRepository;
use App\Repository\ShopDataRepository;
use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
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
    private LoggerInterface $log;

    /**
     * ShopHandlerService constructor.
     * @param ShopRepository $shopRepository
     * @param LocationRepository $locationRepository
     * @param ShopCategoryRepository $categoryRepository
     * @param ShopDataRepository $shopDataRepository
     * @param EntityManagerInterface $entityManager
     * @param ImageHandlerService $imageService
     * @param LoggerInterface $log
     */
    public function __construct(ShopRepository $shopRepository,
                                LocationRepository $locationRepository,
                                ShopCategoryRepository $categoryRepository,
                                ShopDataRepository $shopDataRepository,
                                EntityManagerInterface $entityManager,
                                ImageHandlerService $imageService,
                                LoggerInterface $log)
    {
        $this->shopRepository = $shopRepository;
        $this->locationRepository = $locationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->shopDataRepository = $shopDataRepository;
        $this->entityManager = $entityManager;
        $this->imageService = $imageService;
        $this->log = $log;
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
        $shopDto =   ShopDto::createDtoFromEntity($this->shopRepository->find($id));

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


        if($shopDto->getLocationId() == null ){
            $locationFound = $this->locationRepository->findOneBy(
                [   'latitude' => $shopDto->getLatitude(),
                    'longitude' => $shopDto->getLongitude()]);

            if(!$locationFound){
              $location = LocationDto::createEntityFromShopDtoRequest($shopDto);
             $result->setLocationCreated($this->persist($location)) ;
            }else{
                $location = $locationFound;


            }
            $shop->setLocation($location);
        }else{
            $shop->setLocation($this->locationRepository->find($shopDto->getLocationId()));
            $result->setLocationCreated(Response::HTTP_NOT_MODIFIED);
        }


        if($shopDto->getCategoryId() == null) {
            $shopCategoryFound = $this->categoryRepository->findOneBy(
                ['category' => $shopDto->getCategory()] );

            $category = new ShopCategory();

            if(!$shopCategoryFound){
                $category->setCategory($shopDto->getCategory());
                $result->setCategoryCreated($this->persist($category));
            }else{
                $category = $shopCategoryFound;
                $result->setCategoryCreated(Response::HTTP_NOT_MODIFIED);

            }
            $shop->setShopCategory($category);
        }else {
            $shop->setShopCategory($this->categoryRepository->find($shopDto->getCategoryId()));
            $result->setCategoryCreated(Response::HTTP_NOT_MODIFIED);
        }


        if($shopDto->getShopDataId() == null ){
            $shopDataFound =  $this->shopDataRepository->findOneBy(
                [   'phone' => $shopDto->getPhone(),
                    'description' => $shopDto->getDescription(),
                    'logo' => $shopDto->getLogo()]);
            if(!$shopDataFound){
                $shopData = ShopDataDto::createShopDataFromShopDtoRequest($shopDto, $shop);
                $result->setShopDataCreated($this->persist($shopData));
            }else{
                $shopData = $shopDataFound;
                $result->setShopDataCreated(Response::HTTP_NOT_MODIFIED);
            }
            $shop->setShopData($shopData);
        }else{
            $shop->setShopData($this->shopDataRepository->find($shopDto->getShopDataId()));
            $result->setShopDataCreated(Response::HTTP_NOT_MODIFIED);
        }

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
}



























