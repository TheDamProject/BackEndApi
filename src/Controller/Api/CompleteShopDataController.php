<?php

namespace App\Controller\Api;

use App\Entity\Shop;
use App\Form\Model\CompleteShopDataDto;
use App\Form\Model\ShopDto;
use App\Form\Type\CompleteShopDataType;
use App\Form\Type\ShopFormType;
use App\Service\ShopHandlerService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class CompleteShopDataController extends AbstractController
{
    /**
     * @Rest\Get(path="/shop/complete/{id}")
     * @Rest\View(serializerGroups={"completeShopData"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param Request $request
     * @param ShopHandlerService $shopHandlerService
     * @return CompleteShopDataDto
     * @throws EntityNotFoundException
     */
    public function getCompleteDataAboutShopAction
    (
        int $id,
        Request $request,
        ShopHandlerService $shopHandlerService

    ): CompleteShopDataDto
    {
        $formFactory = Forms::createFormFactory();

        $formGenerated = $shopHandlerService->recoveryCompleteShopData($id);
        if (!$formGenerated) {
            throw new EntityNotFoundException('The Shop with id '.$id.' does not exist!');
        }
        $formFactory->createBuilder(CompleteShopDataType::class, $formGenerated);

        return $formGenerated;
    }

    /**
     * @Rest\Post(path="/shop/complete/add")
     * @Rest\View(serializerGroups={"completeShopData"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param ShopHandlerService $handler
     * @return CompleteShopDataDto|FormInterface
     * @throws EntityNotFoundException
     */
    public function postAddAction
    (
        Request $request,
        ShopHandlerService $handler
    )
    {
        $completeShopData = new CompleteShopDataDto();

        $form = $this->createForm(ShopFormType::class, $completeShopData);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){
            $shopCreated = $handler->createShopAndDataFromRequest($completeShopData);

            if($shopCreated){
                return $shopCreated;
            }
        }
        return $form;
    }
    /**
     * @Rest\Delete(path="/shop/complete/delete/{id}")
     * @Rest\View(serializerGroups={"completeShopData"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param ShopHandlerService $shopHandlerService
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteDataAndShopAction
    (
        int $id,
        ShopHandlerService $shopHandlerService
    ): Response
    {
        $result = $shopHandlerService->deleteCompleteShopAndData($id);

        if($result == Response::HTTP_OK){
            return new Response('DELETED Shop and Data of with id '. $id .' .', Response::HTTP_CREATED);
        }else{
            throw new EntityNotFoundException('The Shop with id '.$id.' does not be deleted! EXISTS?');
        }
    }


}
