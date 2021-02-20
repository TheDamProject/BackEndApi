<?php

namespace App\Controller\Api;

use App\Entity\DataShop;
use App\Entity\Post;
use App\form\Type\PostFormType;
use App\form\Type\ShopDataFormType;
use App\Repository\DataShopRepository;
use App\Repository\PostRepository;
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
    public function getLocations(DataShopRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/shop_data/add")
     * @Rest\View(serializerGroups={"shopData"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $shopData = New DataShop();
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
