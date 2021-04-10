<?php

namespace App\Controller\Api;

use App\Entity\ShopCategory;
use App\Form\Type\CategoryFormType;
use App\Service\CategoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ShopCategoryController extends AbstractController
{

    /**
     * @Rest\Get(path="/categories")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param CategoryHandler $categoryHandler
     * @return ShopCategory[]|Response
     */
    public function getAllAction
    (
        CategoryHandler $categoryHandler
    )
    {
        return $categoryHandler->getAllCategories();
    }


    /**
     * @Rest\Post(path="/category/add")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param CategoryHandler $categoryHandler
     * @return Response
     */
    public function postAddAction
    (
        Request $request,
        CategoryHandler $categoryHandler
    ): Response
    {
        $shopCategory = new ShopCategory();

        $form = $this->createForm(CategoryFormType::class, $shopCategory);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

           return $categoryHandler->addNewCategory($shopCategory);
        }
        return  new Response('ERROR',Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Rest\Delete("/category/delete/{id}")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param CategoryHandler $categoryHandler
     * @return Response
     */
    public function deleteAction
    (
        int $id,
        CategoryHandler $categoryHandler

    ): Response
    {
      return  $categoryHandler->deleteCategoryById($id);

    }

}
