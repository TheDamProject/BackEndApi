<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\form\Type\LocationFormType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;


class LocationController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/locations")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     */
    public function getLocations(LocationRepository $locationRepository)
    {
        return $locationRepository->findAll();
    }

    /**
     * @Rest\Post(path="/locations/add")
     * @Rest\View(serializerGroups={"location"}, serializerEnableMaxDepthChecks=true)
     */

    public function addLocation(EntityManagerInterface $entityManager, Request $request)
    {
        $location = New Location();
        $form = $this->createForm(LocationFormType::class, $location);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()){
            $entityManager->persist($location);
            $entityManager->flush();
            return $location;
        }
        return $form;

    }
}
