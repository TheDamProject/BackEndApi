<?php


namespace App\Controller\Api;


use App\Entity\Shop;
use App\Form\Model\ClientDto;
use App\Form\Model\LoginDto;
use App\Form\Model\ShopDto;
use App\Form\Type\ClientFormType;
use App\Form\Type\LoginFormType;
use App\Form\Type\ShopFormType;
use App\Repository\ClientRepository;
use App\Service\ClientHandlerService;
use App\Service\LoginService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends AbstractController
{

    /**
     * @Rest\Post(path="/login")
     * @Rest\View(serializerGroups={"login"}, serializerEnableMaxDepthChecks=true)
     * @param LoginService $loginService
     * @param Request $request
     */
    public function login
    (
        LoginService $loginService,
        Request $request
    )
    {
        $loginDto = new LoginDto();
        $form = $this->createForm(LoginFormType::class, $loginDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $loginService->handleLoginQuery($loginDto->getUid());


        }

        return Response::HTTP_BAD_REQUEST;
    }


}
