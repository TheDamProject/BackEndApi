<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Form\Model\ClientDto;
use App\Form\Type\ClientFormType;
use App\Repository\ClientRepository;
use App\Service\ClientHandlerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as AbstractControllerAlias;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;


class ClientController extends AbstractControllerAlias
{
    /**
     * @Rest\Get(path="/clients")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param ClientRepository $repository
     * @return array
     */
    public function getAllAction
    (
        ClientRepository $repository

    ): array
    {
        return  $repository->findAll();
    }


    /**
     * @Rest\Get(path="/client/{uid}")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @param ClientRepository $repository
     * @return Client
     * @throws EntityNotFoundException
     */
    public function getByUIDAction
    (
        string $uid,
        ClientRepository $repository
    ): Client
    {
        $client = $repository->findOneBy(['uid' => $uid]);
        if(!$client){
            throw new EntityNotFoundException('The client with id '.$uid.' does not exist!');
        }
        return $client;
    }


    /**
     * @Rest\Post(path="/client/add")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param ClientRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param ClientHandlerService $handlerService
     * @return Response
     */
    public function postAddAction
    (
        ClientRepository $repository,
        EntityManagerInterface $entityManager,
        Request $request,
        ClientHandlerService $handlerService
    ): Response
    {
        $clientDto = new ClientDto();

        $form = $this->createForm(ClientFormType::class, $clientDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $client = $handlerService->createClientFromRequest($clientDto);
            $clientOnDb = $repository->findOneBy(['uid' => $client->getUid()]);

            if($clientOnDb){
                return new Response('Client EXISTS ',Response::HTTP_NOT_MODIFIED);
            }else{
                $entityManager->persist($client);
                $entityManager->flush();
            }
        }
        return new Response('Client CREATED ',Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/client/delete/{uid}")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @param Request $request
     * @param ClientRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteAction
    (
        string $uid,
        Request $request,
        ClientRepository $repository,
        EntityManagerInterface $entityManager

    ): Response
    {
        $clientDto = new ClientDto();

        $form = $this->createForm(ClientFormType::class, $clientDto);
        $form->handleRequest($request);

        $clientOnDb = $repository->findOneBy(['uid' => $uid]);

        if($clientOnDb){
            $entityManager->remove($clientOnDb);
            $entityManager->flush();
            return new Response('Client with uid '. $uid .' DELETED ',Response::HTTP_OK);
        }else{
            throw new EntityNotFoundException('I can NOT delete the client with uid :  '.$uid.' Sorry!!');
        }
    }

    /**
     * @Rest\Delete("/client/deleteUID/{uid}")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @param Request $request
     * @param ClientRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteByUidAction
    (
        string $uid,
        Request $request,
        ClientRepository $repository,
        EntityManagerInterface $entityManager

    ): Response
    {
        $clientDto = new ClientDto();

        $form = $this->createForm(ClientFormType::class, $clientDto);
        $form->handleRequest($request);

        $clientOnDb = $repository->findOneBy(array('uid' => $uid));

        if($clientOnDb){
            $entityManager->remove($clientOnDb);
            $entityManager->flush();
            return new Response('Client with id '. $uid .' DELETED ',Response::HTTP_OK);
        }else{
            throw new EntityNotFoundException('I can NOT delete the client with id :  '.$uid.' Sorry!!');
        }
    }

}
