<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\form\Type\PostTypeFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/categories")
     * @Rest\View (serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(CategoryRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/categories/add")
     * @Rest\View (serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function addPostType(CategoryRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {

        $category = New Category();

        $form = $this->createForm(PostTypeFormType::class,$category);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($category);
            $entityManager->flush();
            return $category;
        }
        return $form;
    }

}
