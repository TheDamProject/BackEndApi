<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\Form\Model\LocationDto;
use App\Form\Type\LocationFormType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class LocationController extends AbstractController
{
    /**
     * @Rest\Get(path="/location")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     * @param LocationRepository $repository
     * @return array
     */
    public function getAllAction
    (
        LocationRepository $repository
    ): array
    {
        return  $repository->findAll();
    }

    /**
     * @Rest\Get(path="/location/{id}")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param LocationRepository $repository
     * @throws EntityNotFoundException
     */
    public function getByIdAction
    (
        int $id,
       LocationRepository $repository
    ): Location
    {
        $location = $repository->find($id);
        if(!$location){
            throw new EntityNotFoundException('The location with id '.$id.' does not exist!');
        }
        return $location;
    }


    /**
     * @Rest\Post(path="/location/add")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     * @param LocationRepository $repository
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function postAddAction
    (
        LocationRepository $repository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $locationDto = new LocationDto();

        $form = $this->createForm(LocationFormType::class, $locationDto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $location = LocationDto::createEntityFromDto($locationDto);

            $locationOnDb = $repository->findBy(['address' => $location->getAddress()]);

            if($locationOnDb){
                return new Response('NOT  created. Exists? ' .$locationDto->getAddress(), Response::HTTP_NOT_MODIFIED);
            }else{
                $entityManager->persist($location);
                $entityManager->flush();
            }

        }
        return new Response('Created :' .$locationDto->getAddress(), Response::HTTP_CREATED);
    }


    /**
     * @Rest\Delete("/location/delete/{id}")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @param Request $request
     * @param LocationRepository $repository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteAction
    (
        int $id,
        Request $request,
        LocationRepository $repository,
        EntityManagerInterface $entityManager

    ): Response
    {
        $locationDto = new LocationDto();

        $form = $this->createForm(LocationFormType::class, $locationDto);
        $form->handleRequest($request);

        $locationOnDb = $repository->find($id);

        if($locationOnDb){
            $entityManager->remove($locationOnDb);
            $entityManager->flush();
            return new Response('Location with id '. $id .' DELETED ',Response::HTTP_OK);
        }else{
            throw new EntityNotFoundException('I can NOT delete the location with id :  '.$id.' Sorry!!');
        }
    }
}
