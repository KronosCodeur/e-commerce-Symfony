<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/shop', name: 'app_shop')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('shop/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    private CategoryRepository $categoryRepository;
}
