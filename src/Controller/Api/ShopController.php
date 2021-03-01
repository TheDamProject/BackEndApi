<?php

namespace App\Controller\Api;


use App\Form\Model\ShopCreationInformerModel;
use App\Form\Model\ShopDto;
use App\Form\Type\ShopFormType;
use App\Form\Type\ShopInformerModelFormType;
use App\Service\ShopHandlerService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

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
     */
    public function getAllAction(): ArrayCollection
    {
        return $this->handler->getAllShops();
    }



    /**
     * @Rest\Get(path="/shop/{id}")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return ShopDto|int
     */
    public function getByIdAction
    (
        int $id
    )
    {
        try {
            return $this->handler->getOneShopById($id);
        } catch (Exception $e) {
            return Response::HTTP_NOT_FOUND;
        }
    }

    /**
     * @Rest\Post(path="/shop/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @return ShopCreationInformerModel|FormInterface
     */
    public function addNewShopAction(Request $request )
    {
        $shopDto = new ShopDto();
        $form = $this->createForm(ShopFormType::class, $shopDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $informer = new ShopCreationInformerModel();
            $form2 = $this->createForm(ShopInformerModelFormType::class, $informer);
            $form2->submit($this->handler->createNewShop($shopDto));
            return $form2;
        }
        return $form;
    }

    /**
     * @Rest\Delete(path="/shop/delete/{id}")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return ShopDto|int
     */
    public function deleteByIdAction
    (
        int $id
    )
    {
        if($this->handler->deleteOneShopById($id)){
            return Response::HTTP_OK;
        }else{
            return Response::HTTP_NOT_MODIFIED;
        }

    }


}














