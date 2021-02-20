<?php

namespace App\Controller\Api;


use App\Entity\TypePost;
use App\form\Type\PostTypeFormType;
use App\Repository\TypePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class TypePostController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/types")
     * @Rest\View (serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(TypePostRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/types/add")
     * @Rest\View (serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function addPostType(Request $request, EntityManagerInterface $entityManager)
    {

        $postType = New TypePost();

        $form = $this->createForm(PostTypeFormType::class,$postType);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($postType);
            $entityManager->flush();
            return $postType;
        }
        return $form;
    }

}
