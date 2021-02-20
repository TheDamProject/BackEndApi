<?php

namespace App\Controller\Api;


use App\Entity\Comentary;
use App\form\Type\CommentaryFormType;
use App\form\Type\PostTypeFormType;
use App\Repository\ComentaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


class CommentaryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/commentaries")
     * @Rest\View (serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function index(ComentaryRepository $repository)
    {
        return $repository->findAll();
    }

    /**
     * @Rest\Post(path="/commentaries/add")
     * @Rest\View (serializerGroups={"commentary"}, serializerEnableMaxDepthChecks=true)
     */
    public function addPostType( Request $request, EntityManagerInterface $entityManager)
    {

        $commentary = New Comentary();

        $form = $this->createForm(CommentaryFormType::class,$commentary);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($commentary);
            $entityManager->flush();
            return $commentary;
        }
        return $form;
    }
}
