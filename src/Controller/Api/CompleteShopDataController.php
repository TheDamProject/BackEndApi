<?php

namespace App\Controller\Api;

use App\Form\Type\CompleteShopDataType;
use App\Service\ShopHandlerService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @throws EntityNotFoundException
     */
    public function getCompleteDataAboutShopAction
    (
        int $id,
        Request $request,
        ShopHandlerService $shopHandlerService

    )
    {
        $formFactory = Forms::createFormFactory();

        $formGenerated = $shopHandlerService->recoveryCompleteShopData($id);
        if (!$formGenerated) {
            throw new EntityNotFoundException('The Shop with id '.$id.' does not exist!');
        }
        $formFactory->createBuilder(CompleteShopDataType::class, $formGenerated);

        return $formGenerated;
    }


}
