<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/addboutique', name: 'app_addboutique')]
    public function appLogin(): Response{
        return $this-> render('shop/boutique.html.twig');
    }
    #[Route("/category/boutique",name: "categoryBoutique",methods: ['POST'])]
    public function addboutique(Request $request,UserRepository $userRepository)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $user=$userRepository->findBy(['email'=>$email,'password'=>$password]);
        if ($user!=null){
            return $this->redirectToRoute('app_home',[
                'data' => $user,
            ]);
        }else{
            $this->addFlash('error', 'invalid credentials');
            return $this->redirectToRoute('app_addboutique');
        }
    }


    private CategoryRepository $categoryRepository;
}
