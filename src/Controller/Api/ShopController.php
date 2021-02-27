<?php

namespace App\Controller\Api;


use App\Entity\Shop;
use App\Form\Model\ShopDto;
use App\Form\Type\ShopFormType;
use App\Repository\ShopRepository;
use App\Service\ShopHandlerService;
use Doctrine\ORM\EntityNotFoundException;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * @Rest\Get(path="/shop/{id}")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param ShopRepository $repository
     * @param int $id
     * @return Shop
     */
    public function getByIdAction
    (
        int $id,
        ShopRepository $repository
    ) : Shop
    {
        return  $repository->find($id);
    }


    /**
     * @Rest\Post(path="/shop/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param ShopHandlerService $handler
     * @return Shop|FormInterface
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














