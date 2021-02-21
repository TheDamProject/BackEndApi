<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class PostTypeController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/postType")
     * @Rest\View(serializerGroups={"postType"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction
    (

    )
    {
        return $this->render('post_type/index.html.twig', [
            'controller_name' => 'PostTypeController',
        ]);
    }
}
