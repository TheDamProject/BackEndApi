<?php

namespace App\Controller\Api;


use App\Entity\Comentary;
use App\form\Model\CommentaryDto;
use App\form\Type\CommentaryFormType;
use App\Repository\ClientRepository;
use App\Repository\ComentaryRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class CommentaryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/commentaries")
     * @Rest\View (serializerGroups={"comentary"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(ComentaryRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/commentaries/add")
     * @Rest\View (serializerGroups={"commentary"}, serializerEnableMaxDepthChecks=true)
     */
    public function addPostType( Request $request, EntityManagerInterface $entityManager, ShopRepository $shopRepository, ClientRepository $clientRepository)
    {

        $commentaryDto = New CommentaryDto();

        $form = $this->createForm(CommentaryFormType::class,$commentaryDto);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $clientData = $clientRepository->findBy(array('id' => $commentaryDto->clientRelated));
            $shopData = $shopRepository->findBy(array('id' => $commentaryDto->shopComentaryRelated));
            $commentary = New Comentary();

            $commentary->setClientRelated($clientData[0]);
            $commentary->setContentComentary($commentaryDto->contentComentary);
            $commentary->setShopComentaryRelated($shopData[0]);

            $entityManager->persist($commentary);
            $entityManager->flush();
            return $commentaryDto;
        }
        return $form;
    }
}
