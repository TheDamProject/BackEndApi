<?php

namespace App\Controller\Api;

use App\Entity\PostType;
use App\form\Type\PostTypeFormType;
use App\Repository\PostTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class PostTypeController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/post_types")
     * @Rest\View (serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(PostTypeRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/post_types/add")
     * @Rest\View (serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function addPostType(PostTypeRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {

        $postType = New PostType();

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
