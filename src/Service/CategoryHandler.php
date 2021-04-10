<?php


namespace App\Service;


use App\Entity\ShopCategory;
use App\Repository\ShopCategoryRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CategoryHandler
{

    private ShopCategoryRepository $categoryRepository;
    private EntityManagerInterface $entityManager;

    /**
     * CategoryHandler constructor.
     * @param ShopCategoryRepository $categoryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ShopCategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }


    public function getAllCategories()
    {
        $categoryList = $this->categoryRepository->findAll();
        if($categoryList){
            return $categoryList;
        }
        return  new Response('NO CATEGORIES IN DATABASE',Response::HTTP_NO_CONTENT);
    }


    public function addNewCategory(ShopCategory $shopCategory): Response
    {
        $categoryOnDb = $this->categoryRepository->findBy(['category' => $shopCategory->getCategory()]);

        if($categoryOnDb){
            return  new Response('This category EXISTS on database',Response::HTTP_NOT_MODIFIED);
        }else{
            $this->entityManager->persist($shopCategory);
            $this->entityManager->flush();
            return new Response('Created :' .$shopCategory->getCategory(). '' , Response::HTTP_CREATED);
        }
    }

    public function deleteCategoryById($id): Response
    {

        try{
            $categoryOnDb = $this->categoryRepository->find($id);
            if($categoryOnDb){
                $this->entityManager->remove($categoryOnDb);
                $this->entityManager->flush();
                return new Response('CATEGORY with id '. $id .' DELETED ',Response::HTTP_OK);
            }else{
                return new Response('I can NOT delete the CATEGORY with id :  '.$id.' Sorry!!', Response::HTTP_NOT_MODIFIED);
            }
        }catch (\Exception $exception){
            return new Response('ERROR  '.$exception . ' Sorry!!', Response::HTTP_NOT_MODIFIED);
        }

    }
}