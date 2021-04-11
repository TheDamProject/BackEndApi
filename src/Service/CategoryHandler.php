<?php


namespace App\Service;


use App\Entity\ShopCategory;
use App\Repository\ShopCategoryRepository;
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
        return  new Response(Response::HTTP_NO_CONTENT);
    }


    public function addNewCategory(ShopCategory $shopCategory)
    {
        $categoryOnDb = $this->categoryRepository->findBy(['category' => $shopCategory->getCategory()]);

        if($categoryOnDb){
            return  new Response(null,Response::HTTP_NOT_MODIFIED);
        }else{
            $this->entityManager->persist($shopCategory);
            $this->entityManager->flush();
            return $shopCategory;
        }
    }

    public function deleteCategoryById($id)
    {

        try{
            $categoryOnDb = $this->categoryRepository->find($id);
            if($categoryOnDb){
                $category = $categoryOnDb;
                $this->entityManager->remove($categoryOnDb);
                $this->entityManager->flush();
                return $category;
            }else{
                return new Response(null,Response::HTTP_NOT_MODIFIED);
            }
        }catch (\Exception $exception){
            return new Response(null,Response::HTTP_NOT_MODIFIED);
        }

    }
}