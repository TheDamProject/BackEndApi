<?php


namespace App\Service;


use App\Entity\Client;
use App\Form\Model\ClientDto;
use App\Repository\ClientRepository;
use App\Utils\Constants;
use Doctrine\ORM\EntityManagerInterface;
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


    public function createClientFromRequest(ClientDto $clientDto): Client
    {

        $fileNameImage = $this->imageService->saveImage($clientDto->getAvatar(),Constants::CLIENT_AVATAR_DIRECTORY );
        $clientDto->setAvatar($this->urlHelper->getAbsoluteUrl(constants::pathOfImagesByDefault. $fileNameImage));
        return ClientDto::createEntityFromDto($clientDto);
    }



}