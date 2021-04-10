<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Form\Model\ClientDto;
use App\Form\Type\ClientFormType;
use App\Service\ClientHandlerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AbstractControllerAlias;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;


class ClientController extends AbstractControllerAlias
{
    private ClientHandlerService $clientService ;

    /**
     * ClientController constructor.
     * @param ClientHandlerService $clientService
     */
    public function __construct(ClientHandlerService $clientService)
    {
        $this->clientService = $clientService;
    }


    /**
     * @Rest\Get(path="/clients")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllAction()
    {
        return  $this->clientService->getAllClients();
    }

    /**
     * @Rest\Get(path="/client/{uid}")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @return Client|Response
     */
    public function getByUIDAction
    (
        string $uid
    )
    {
        return $this->clientService->getClientByUID($uid);
    }

    /**
     * @Rest\Post(path="/client/add")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @return Response
     */
    public function postAddAction
    (
        Request $request
    ): Response
    {
        $clientDto = new ClientDto();
        $form = $this->createForm(ClientFormType::class, $clientDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
           return $this->clientService->createClientFromRequest($clientDto);
        }
        return new Response('ERROR',Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete("/client/deleteUID/{uid}")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @param Request $request
     * @return Response
     */
    public function deleteByUidAction
    (
        string $uid,
        Request $request

    ): Response
    {
        $clientDto = new ClientDto();
        $form = $this->createForm(ClientFormType::class, $clientDto);
        $form->handleRequest($request);

        return $this->clientService->deleteClientByUID($uid);

    }

}
