<?php

namespace App\Controller\Api;


use App\Entity\Shop;
use App\Form\Model\ShopDto;
use App\Form\Model\ShopsRequestDto;
use App\Form\Type\ShopFormType;
use App\Form\Type\ShopListFormType;
use App\Repository\ShopRepository;
use App\Service\ShopHandlerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ShopController extends AbstractController
{
     private ShopHandlerService $handler;


    /**
     * ShopController constructor.
     * @param ShopHandlerService $handler
     */
    public function __construct(ShopHandlerService $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Rest\Get(path="/shops")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param ShopRepository $repo
     * @return array|Response
     */
    public function getAllAction(ShopRepository $repo)
    {
        return $this->handler->getAllShops();
    }


    /**
     * @Rest\Get(path="/shop/{uid}")
     * @Rest\View(serializerGroups={"shopDto"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     * @return ShopDto|Response
     */
    public function getByIdAction
    (
        string $uid
    )
    {
        return $this->handler->getOneShopById($uid);
    }

    /**
     * @Rest\Post(path="/shop/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @return ShopDto|Response
     */
    public function addNewShopAction(Request $request)
    {
        $shopDto = new ShopDto();
        $form = $this->createForm(ShopFormType::class, $shopDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            return $this->handler->createNewShop($shopDto);
        }
        return new Response('Ups Shop does not added',Response::HTTP_NOT_MODIFIED);
    }

    /**
     * @Rest\Delete(path="/shop/delete/{uid}")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     */
    public function deleteByIdAction
    (
        string $uid
    )
    {
        return $this->handler->deleteOneShopById($uid);
    }


    /**
     * @Rest\Post(path="/shops")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @return Shop[]|int|Response
     */
    public function getShopsListAction(Request $request  )
    {
        $shopRequestDto = new ShopsRequestDto();
        $form = $this->createForm(ShopListFormType::class , $shopRequestDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $this->handler->getShopsAndPostsInRange($shopRequestDto);

            return $data;
        }
        return new Response('Ups ',Response::HTTP_NOT_FOUND);
    }






}














