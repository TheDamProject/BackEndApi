<?php

namespace App\Controller\Api;


use App\Form\Model\ShopDto;
use App\Form\Type\ShopFormType;
use App\Repository\ShopRepository;
use App\Service\ShopHandlerService;
use Doctrine\ORM\EntityNotFoundException;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Console\Output\OutputInterface;

class ShopController extends AbstractController
{
    /**
     * @Rest\Get(path="/shops")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param ShopRepository $repository
     * @return array
     */
    public function getAllAction
    (
        ShopRepository $repository
    ): array
    {
        return  $repository->findAll();
    }

    /**
     * @Rest\Post(path="/shop/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param ShopHandlerService $handler
     * @throws EntityNotFoundException
     */
    public function postAddAction
    (
        Request $request,
        ShopHandlerService $handler

    )
    {
        $shopDto = new ShopDto();

        $form = $this->createForm(ShopFormType::class, $shopDto);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $shopCreated = $handler->createShopFromRequest($shopDto);

            if($shopCreated){

                return $shopCreated;
            }
        }
        return $form;

    }

}














