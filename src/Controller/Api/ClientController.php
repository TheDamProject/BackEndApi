<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Entity\Post;
use App\form\Type\PostFormType;
use App\form\Type\ClientFormType;
use App\Repository\ClientRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/users")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     */
    public function getLocations(ClientRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/users/add")
     * @Rest\View(serializerGroups={"client"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $user = New Client();
        $form = $this->createForm(ClientFormType::class, $user);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $user;
        }
        return $form;

    }
}
