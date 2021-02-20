<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\form\Type\LocationFormType;
use App\form\Type\PostFormType;
use App\Repository\LocationRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;



class PostController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/post")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     */
    public function getLocations(PostRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/post/add")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $post = New Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($post);
            $entityManager->flush();
            return $post;
        }
        return $form;

    }
}
