<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\Shop;
use App\form\Type\PostFormType;
use App\form\Type\ShopFormType;
use App\Repository\PostRepository;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/shops")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     */
    public function getLocations(ShopRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/shops/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $shop = New Shop();
        $form = $this->createForm(ShopFormType::class, $shop);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($shop);
            $entityManager->flush();
            return $shop;
        }
        return $form;

    }
}
