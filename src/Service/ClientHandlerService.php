<?php


namespace App\Service;


use App\Form\Model\ClientDto;
use App\Repository\ClientRepository;
use App\Utils\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;

class ClientHandlerService
{
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;
    private ImageHandlerService $imageService;
    private UrlHelper $urlHelper;

    /**
     * PostHandlerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     * @param ImageHandlerService $imageService
     * @param UrlHelper $urlhelper
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository,ImageHandlerService $imageService, UrlHelper $urlhelper)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->imageService = $imageService;
        $this->urlHelper = $urlhelper;
    }

    public function getAllClients()
    {
        $clientList = $this->clientRepository->findAll();

        if($clientList){
            return $clientList;
        }
        return  new Response('No clients in database ',Response::HTTP_NO_CONTENT);
    }

    public function createClientFromRequest(ClientDto $clientDto): Response
    {
        $fileNameImage = $this->imageService->saveImage($clientDto->getAvatar(),Constants::CLIENT_AVATAR_DIRECTORY );
        $clientDto->setAvatar($this->urlHelper->getAbsoluteUrl(constants::pathOfImagesByDefault. $fileNameImage));

        $client = ClientDto::createEntityFromDto($clientDto);

        $clientOnDb = $this->clientRepository->findOneBy(['uid' => $client->getUid()]);

        if($clientOnDb){
            return new Response('Client EXISTS ',Response::HTTP_NOT_MODIFIED);
        }else{
            $this->entityManager->persist($client);
            $this->entityManager->flush();

            return new Response('Client created ',Response::HTTP_CREATED);
        }

    }

    public function getClientByUID(string $uid)
    {
        $client = $this->clientRepository->findOneBy(['uid' => $uid]);
        if(!$client){
            return  new Response('The client width'. $uid . 'does not exists',Response::HTTP_NO_CONTENT);
        }
        return $client;
    }

    public function deleteClientByUID(string $uid): Response
    {
        $clientOnDb = $this->clientRepository->findOneBy(array('uid' => $uid));

        if($clientOnDb){
            $this->entityManager->remove($clientOnDb);
            $this->entityManager->flush();
            return new Response('Client with id '. $uid .' DELETED ',Response::HTTP_OK);
        }
        return new Response('Can not delete Client with uid '. $uid ,Response::HTTP_NOT_MODIFIED);

    }


}