<?php

namespace App\Controller\Api;


use App\Entity\Category;
use App\form\Type\CategoriesFormType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class CategoryController extends AbstractFOSRestController
{

    public function index(CategoryRepository $repository)
    {
        return $repository->findAll();
    }

    /**
 * @Rest\Get
     *
     */
    public function addPostType( Request $request, EntityManagerInterface $entityManager)
    {

        $category = New Category();

        $form = $this->createForm(CategoriesFormType::class,$category);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($category);
            $entityManager->flush();
            return $category;
        }
        return $form;
    }

}
