<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\PostType;
use App\Form\Model\PostTypeDto;
use App\Form\Type\TypeFormType;
use App\Repository\PostTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use PhpParser\Node\Expr\Throw_;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


class PostTypeController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/postType")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction
    (
        PostTypeRepository $postTypeRepository
    ): array
    {
        return $postTypeRepository->findAll();
    }


    /**
     * @Rest\Post(path="/postType/add")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction
    (
        EntityManagerInterface $entityManager,
        Request $request,
        PostTypeRepository $postTypeRepository
    )
    {
        $postTypeDto = new PostTypeDto();

        $form = $this->createForm(TypeFormType::class, $postTypeDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
           $postType = new PostType();
           $postType->setType($postTypeDto->type);

           $typeInRepo = $postTypeRepository->findBy(['type' => $postTypeDto->type]);
            if(!$typeInRepo){
                $entityManager->persist($postType);

                $entityManager->flush();
                return $postType;
            }else{
                return new Response('', Response::HTTP_NOT_MODIFIED);
            }

        }
        return $form;
    }
}
