<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\ShopData;
use App\form\Type\PostFormType;
use App\form\Type\ShopDataFormType;
use App\Repository\PostRepository;
use App\Repository\ShopDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class ShopDataController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/shop_data")
     * @Rest\View(serializerGroups={"shopData"}, serializerEnableMaxDepthChecks=true)
     */
    public function getLocations(ShopDataRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/shop_data/add")
     * @Rest\View(serializerGroups={"shopData"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $shopData = New ShopData();
        $form = $this->createForm(ShopDataFormType::class, $shopData);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($shopData);
            $entityManager->flush();
            return $shopData;
        }
        return $form;

    }
}
