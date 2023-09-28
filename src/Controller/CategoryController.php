<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    private CategoryRepository $categoryRepository;
    #[Route('/api/category/createCategory',name:'createCategory',methods: ['POST'])]
    public function createCategory(Request $request,EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(),true);
        $name = $data['name'];
        $code = strtoupper(substr(substr((explode(' ',$name))[1],'0',5).uniqid("P"),0,8));
        $description = $data['description'];
        $category = new Category();
        $category->setName($name);
        $category->setCode($code);
        $category->setDescription($description);
        $entityManager->persist($category);
        $entityManager->flush();
        return new Response("Category creer avec succes",Response::HTTP_OK);
    }
}
