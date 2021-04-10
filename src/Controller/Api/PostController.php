<?php

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\Model\PostDto;
use App\Form\Type\PostFormType;
use App\Repository\PostRepository;
use App\Service\PostHandlerService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class PostController extends AbstractController
{

    /**
     * @Rest\Post(path="/post/add")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     * @param PostHandlerService $handlerService
     * @param Request $request
     * @return Response
     */
    public function postAddAction
    (
        PostHandlerService $handlerService,
        Request $request
    ): Response
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
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param PostHandlerService $handlerService
     * @return Response
     */
    public function deleteByIdAction
    (
        int $id,
        PostHandlerService $handlerService
    ): Response
    {
       return $handlerService->deletePost($id);

    }


}