<?php

namespace App\Controller\Api;


use App\Entity\Client;
use App\Entity\Comentary;
use App\form\Model\ClientDto;
use App\form\Model\CommentaryDto;
use App\form\Type\CommentaryFormType;
use App\Repository\ClientRepository;
use App\Repository\CommentaryRepository;
use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommentaryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/commentaries")
     * @Rest\View (serializerGroups={"comentary"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(CommentaryRepository $repository)
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
            $shopData = $shopRepository->findBy(array('id' => $commentaryDto->shopCommentaryRelated));
            $commentary = New Comentary();

            $commentary->setClientRelated($clientData[0]);
            $commentary->setContentComentary($commentaryDto->contentCommentary);
            $commentary->setShopComentaryRelated($shopData[0]);

            $entityManager->persist($commentary);
            $entityManager->flush();
            return $commentaryDto;
        }
        return $form;
    }


    /**
     * @Rest\Post(path="/commentaries/edit{id}" , requirements= {"id" = "\d+"})
     * @Rest\View (serializerGroups={"commentary"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        int $id,
        EntityManagerInterface $em,
        CommentaryRepository $commentaryRepository,
        ClientRepository $clientRepository,
        ShopRepository  $shopRepository,
        Request $request

    )
    {   //commentary padido desde fuera rescatado de la bbdd
        $commentary = $commentaryRepository->find($id);
        if (!$commentary) {
            throw $this->createNotFoundException('Commentary not found');
        }

        //dto empleado para crear el nuevo y despues actualizarlo
        $commentaryDto = new CommentaryDto();
        $commentaryDto = CommentaryDto::createFromCommentary($commentary);


        //recorriendo la lista de clientes que tenia antes y guardandolo en un array
        $originallyCLiens = new ArrayCollection();
        foreach ($commentary->getClients() as $client) {
            $clientDto = ClientDto::createFromClient($client);
            $commentaryDto->clientRelated[] = $clientDto;
            $originallyCLiens->add($clientDto);
        }

        //ACTUALIZACIÓN DE CLIENTES

        $form = $this->createForm(CommentaryFormType::class, $commentaryDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            // si es válido el formulario recooremos las categorias originales 
            foreach ($originallyCLiens as $originalClientDto) {
                //Si no envian un cliente de los que estaban registrados, lo eliminamos
                if (!in_array($originalClientDto, $commentaryDto->clientRelated)) {
                    $client = $clientRepository->find($originalClientDto->id);
                    $commentary->removeClient($client);

                }
            }

            //Si envian un cliente que no estubiera en la lista de clientes antes, se añade
            foreach ($commentaryDto->clientRelated as $newClientDto) {
                if (!$originallyCLiens->contains($newClientDto)) {
                    $client = $clientRepository->find($newClientDto->id ?? 0);
                    if (!$client) {

                        $client->setName($newClientDto->name);
                        $client->setSurname($newClientDto->surname);
                        $client->setEmail($newClientDto->email);
                        $client->setNick($newClientDto->nick);
                        $client->setAvatar($newClientDto->avatar);
                        $client->setUidFirebase($newClientDto->uid_firebase);
                        $client->setPostLike($newClientDto->postLikes);
                        $em->persist($client);

                    }
                    $commentary->addClient($client);
        // FIN ACTUALIZACION DE CLIENTES
                }
            }
            $commentary->setContentComentary($commentaryDto->contentCommentary);
            $em->persist($commentary);
            $em->refresh($commentary);
            $em->flush();
        }
       return $commentary;
    }
}




















