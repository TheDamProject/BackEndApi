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
    private ClientHandlerService $clientService;
    private ShopRepository $shopRepository;
    private ShopHandlerService $shopHandler;


    public function __construct
    (EntityManagerInterface $entityManager,
     ClientRepository $clientRepository,
     ClientHandlerService $clientService,
     ShopRepository $shopRepository,
     ShopHandlerService $shopHandler)
    {
        $this->entityManager = $entityManager;
        $this->clientService = $clientService;
        $this->clientRepository = $clientRepository;
        $this->shopRepository = $shopRepository;
        $this->shopHandler = $shopHandler;

    }

    public function handleLoginQuery(string $uid)
    {

        $clientFromDatabase = $this->clientRepository->findOneBy(['uid' => $uid]);
        $shopFromDatabase = $this->shopRepository->findOneBy(['uid' => $uid]);

        if ($clientFromDatabase) {
            return [
               'uid' => $clientFromDatabase->getUid(),
                'nick' => $clientFromDatabase->getNick(),
                'avatar' => $clientFromDatabase->getAvatar()
            ];
        }


        if ($shopFromDatabase) {
            return $this->shopHandler->getOneShopById($uid);
        }

        return new Response('ERROR NOT FOUND',Response::HTTP_NOT_FOUND);
    }


}