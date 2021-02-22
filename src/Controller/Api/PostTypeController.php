<?php

namespace App\Controller\Api;


use App\Entity\PostType;
use App\Form\Model\PostTypeDto;
use App\Form\Type\TypeFormType;
use App\Repository\PostTypeRepository;
use App\Service\PostTypeHandler;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class PostTypeController extends AbstractFOSRestController
{


    /**
     * @Rest\Get(path="/postType")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     * @param PostTypeRepository $postTypeRepository
     * @return array
     */
    public function getAllAction
    (
        PostTypeRepository $postTypeRepository
    ): array
    {
        return  $postTypeRepository->findAll();
    }

    /**
     * @Rest\Get(path="/postType/{id}")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param PostTypeRepository $postTypeRepository
     * @return PostType|Response
     */
    public function getByIdAction
    (
        int $id,
        PostTypeRepository $postTypeRepository
    )
    {
        $postType = $postTypeRepository->find($id);
        if(!$postType){
            throw new EntityNotFoundException('The PostType with id '.$id.' does not exist!');
        }
        return $postType;
    }


    /**
     * @Rest\Post(path="/postType/add")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param PostTypeHandler $handler
     * @return Response
     */
    public function postAddAction
    (
        Request $request,
        PostTypeHandler $handler
    ): Response
    {
        $postTypeDto = new PostTypeDto();
        $form = $this->createForm(TypeFormType::class, $postTypeDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
           $postType = $handler->generateEntityFromDto($postTypeDto);

           if($handler->existsPostType($postTypeDto)){
               throw new HttpException(304,'The PostType '. $postTypeDto->getType().' exist!');
           }else{
               $handler->persistPostType($postType);
           }

        }
        return new Response('Created :' .$postTypeDto->getType(). '' , Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/postType/delete/{id}")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param Request $request
     * @param PostTypeHandler $handler
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteAction
    (
        int $id,
        Request $request,
        PostTypeHandler $handler

    ): Response
    {
        $postTypeDto = new PostTypeDto();

        $form = $this->createForm(TypeFormType::class, $postTypeDto);
        $form->handleRequest($request);

        if($handler->removePostTypeById($id)){
            return new Response('PostType with id '. $id .' DELETED ',Response::HTTP_OK);
        }else{

            throw new EntityNotFoundException('I can NOT delete the PostType with id :  '.$id.' Sorry!!');
        }
    }


}
