<?php

namespace App\Controller\Api;

use App\Form\Model\PostDto;
use App\Form\Type\PostFormType;
use App\Service\PostHandlerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class PostController extends AbstractController
{

    /**
     * @Rest\Get(path="/posts")
     * @Rest\View(serializerGroups={"postEntity"}, serializerEnableMaxDepthChecks=true)
     * @param PostHandlerService $handler
     * @return array|Response
     */
    public function getAllAction(PostHandlerService $handler)
    {
        return $handler->getAllPosts();
    }


    /**
     * @Rest\Post(path="/post/add")
     * @Rest\View(serializerGroups={"postEntity"}, serializerEnableMaxDepthChecks=true)
     * @param PostHandlerService $handlerService
     * @param Request $request
     */
    public function postAddAction
    (
        PostHandlerService $handlerService,
        Request $request
    )
    {
        $postDto = new PostDto();

        $form = $this->createForm(PostFormType::class, $postDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            return $handlerService->createPostFromRequest($postDto);
        }
        return new Response('ERROR',  Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete(path="/post/delete/{id}")
     * @Rest\View(serializerGroups={"postEntity"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param PostHandlerService $handlerService
     */
    public function deleteByIdAction
    (
        int $id,
        PostHandlerService $handlerService
    )
    {
       return $handlerService->deletePost($id);

    }


}