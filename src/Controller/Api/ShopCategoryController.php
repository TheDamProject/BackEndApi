<?php

namespace App\Controller\Api;

use App\Entity\ShopCategory;
use App\Form\Type\CategoryFormType;
use App\Repository\ShopCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

class ShopCategoryController extends AbstractController
{

    /**
     * @Rest\Get(path="/categories")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param ShopCategoryRepository $repository
     * @return array
     */
    public function getAllAction
    (
        ShopCategoryRepository $repository
    ): array
    {
        return  $repository->findAll();
    }

    /**
     * @Rest\Get(path="/category/{id}")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param ShopCategoryRepository $repository
     * @return ShopCategory|Response
     * @throws EntityNotFoundException
     */
    public function getByIdAction
    (
        int $id,
        ShopCategoryRepository $repository
    )
    {
        $shopCategory = $repository->find($id);
        if(!$shopCategory){
            throw new EntityNotFoundException('The category with id '.$id.' does not exist!');
        }
        return $shopCategory;
    }


    /**
     * @Rest\Post(path="/category/add")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param ShopCategoryRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function postAddAction
    (
        ShopCategoryRepository $repository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $shopCategory = new ShopCategory();

        $form = $this->createForm(CategoryFormType::class, $shopCategory);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $categoryOnDb = $repository->findBy(['category' => $shopCategory->getCategory()]);

            if($categoryOnDb){
                throw new HttpException(304,'The Category '. $shopCategory->getCategory().' exist!');
            }else{
               $entityManager->persist($shopCategory);
               $entityManager->flush();
            }

        }
        return new Response('Created :' .$shopCategory->getCategory(). '' , Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/category/delete/{id}")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param Request $request
     * @param ShopCategoryRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteAction
    (
        int $id,
        Request $request,
        ShopCategoryRepository $repository,
        EntityManagerInterface $entityManager

    ): Response
    {
        $shopCategory = new ShopCategory();

        $form = $this->createForm(CategoryFormType::class, $shopCategory);
        $form->handleRequest($request);

        $categoryOnDb = $repository->find($id);

        if($categoryOnDb){
            $entityManager->remove($categoryOnDb);
            $entityManager->flush();
            return new Response('PostType with id '. $id .' DELETED ',Response::HTTP_OK);
        }else{
            throw new EntityNotFoundException('I can NOT delete the PostType with id :  '.$id.' Sorry!!');
        }
    }

}
