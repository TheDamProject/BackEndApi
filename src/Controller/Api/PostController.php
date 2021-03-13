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
     * @Rest\Get(path="/posts")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     * @param PostRepository $repository
     * @return array
     */
    public function getAllAction
    (
        PostRepository $repository
    ): array
    {

       return $repository->findAll();
    }

    /**
     * @Rest\Get(path="/post/{id}")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param PostRepository $repository
     * @return Post
     * @throws EntityNotFoundException
     */
    public function getByIdAction
    (
        int $id,
        PostRepository $repository
    ): Post
    {
        $post = $repository->find($id);
        if(!$post){
            throw new EntityNotFoundException('The post with id '.$id.' does not exist!');
        }
        return $post;
    }

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
            try {
                $post = $handlerService->createPostFromRequest($postDto);
            } catch (\Exception $e) {
                return new Response('Post NOT CREATED  INCORRECT DATA REQUEST',  Response::HTTP_NOT_MODIFIED);
            }

            if(!$handlerService->persistPost($post)){
                return new Response('Post NOT CREATED  ',  Response::HTTP_NOT_MODIFIED);
            }
        }
        return new Response('Post Created Ok ',  Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(path="/post/delete/{id}")
     * @Rest\View(serializerGroups={"post"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param PostHandlerService $handlerService
     * @param PostRepository $repository
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteByIdAction
    (
        int $id,
        PostHandlerService $handlerService,
        PostRepository $repository
    )
    {
        $post = $repository->find($id);
        if(!$post){
            throw new EntityNotFoundException('The Post with id '.$id.' does not exist!');
        }

        try {
            $handlerService->deletePost($post);
        } catch (Exception $e) {
           return new Response( $e , Response::HTTP_NOT_MODIFIED);
        }
        return new Response('Post deleted Ok' , Response::HTTP_OK);
    }


}
