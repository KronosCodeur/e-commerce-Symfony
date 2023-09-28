<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/product/createProduct',name:'createProduct',methods: ['POST'])]
    public function createProduct(Request $request,EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $data = json_decode($request->getContent(),true);
        $name = $data['name'];
        $categoryCode = $data['category'];
        $description = $data['description'];
        $price = $data['price'];
        $category = $categoryRepository->findOneBy(['code'=>$categoryCode]);
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setCategorie($category);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response("Produit creer avec succes",Response::HTTP_OK);
    }
}
