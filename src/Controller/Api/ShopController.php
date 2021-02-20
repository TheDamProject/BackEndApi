<?php

namespace App\Controller\Api;

use App\Entity\Shop;
use App\form\Type\ShopFormType;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

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
