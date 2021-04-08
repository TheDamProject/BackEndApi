<?php

namespace App\Controller\Api;


use App\Entity\Shop;
use App\Form\Model\ShopCreationInformerModel;
use App\Form\Model\ShopDto;
use App\Form\Model\ShopsRequestDto;
use App\Form\Type\ShopFormType;
use App\Form\Type\ShopListFormType;
use App\Repository\ShopRepository;
use App\Service\ShopHandlerService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

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
     */
    public function getAllAction(ShopRepository $repo): array
    {
        return $this->handler->getAllShops();
    }


    /**
     * @Rest\Get(path="/shop/{uid}")
     * @Rest\View(serializerGroups={"shopDto"}, serializerEnableMaxDepthChecks=true)
     * @param string $uid
     */
    public function getByIdAction
    (
        string $uid
    )
    {
        try {
            return $this->handler->getOneShopById($uid);
        } catch (Exception $e) {
            return Response::HTTP_NOT_FOUND;
        }
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

    /**
     * @Rest\Post(path="/shop/add")
     * @Rest\View(serializerGroups={"shop"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param LoggerInterface $log
     * @param SerializerInterface $serializer
     */
    public function addNewShopAction(Request $request, LoggerInterface $log, SerializerInterface $serializer)
    {
        $shopDto = new ShopDto();
        $form = $this->createForm(ShopFormType::class, $shopDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $this->handler->createNewShop($shopDto);

            return [
                'location' => $data->getLocationCreated(),
                'ShopData' => $data->getShopDataCreated(),
                'Category' => $data->getCategoryCreated(),
                'shop' => $data->getShopCreated()
            ];
        }
        return new Response('Ups Shop does not added',Response::HTTP_NOT_MODIFIED);
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














