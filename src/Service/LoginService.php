<?php


namespace App\Service;

use App\Form\Model\ClientDto;
use App\Repository\ClientRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AbstractControllerAlias;
use Symfony\Component\HttpFoundation\Response;

class LoginService extends AbstractControllerAlias
{

    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;
    private ShopRepository $shopRepository;
    private ShopHandlerService $shopHandler;


    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, ShopRepository $shopRepository, ShopHandlerService $shopHandler)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->shopRepository = $shopRepository;
        $this->shopHandler = $shopHandler;

    }


    public function handleLoginQuery(string $uid)
    {
        $clientFromDatabase = $this->clientRepository->findOneBy(['uid' => $uid]);
        if ($clientFromDatabase) {
            $clientDto = ClientDto::createDtoFromEntity($clientFromDatabase);
            return [
                'type' => "client",
                'uid' => $clientFromDatabase->getUid(),
                'nick' => $clientFromDatabase->getNick(),
                'avatar' => $clientFromDatabase->getAvatar()
            ];

        }

        $shopFromDatabase = $this->shopRepository->findOneBy(['uid' => $uid]);

        if ($shopFromDatabase) {

            try {
                $shopFromDatabase = $this->shopHandler->getOneShopById($shopFromDatabase->getId());

                return [
                    'type' => "shop",
                    "uid" => $shopFromDatabase->getUid(),
                    "name"=> $shopFromDatabase->getName(),
                    "location_id"=> $shopFromDatabase->getLocationId(),
                    "latitude"=> $shopFromDatabase->getLatitude(),
                    "longitude"=> $shopFromDatabase->getLongitude(),
                    "address"=> $shopFromDatabase->getAddress(),
                    "shopData_id"=> $shopFromDatabase->getShopDataId(),
                    "phone"=> $shopFromDatabase->getPhone(),
                    "isWhatsapp"=> $shopFromDatabase->getIsWhatsapp(),
                    "description"=> $shopFromDatabase->getDescription(),
                    "logo"=> $shopFromDatabase->getLogo(),
                    "category_id"=> $shopFromDatabase->getCategoryId(),
                    "category"=> $shopFromDatabase->getCategory()
                ];


            } catch (\Exception $e) {

                return Response::HTTP_NOT_FOUND;
            }
        }

        return Response::HTTP_NOT_FOUND;
    }


}