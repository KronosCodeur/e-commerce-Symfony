<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function appLogin(): Response{
        return $this-> render('authentication/login.html.twig');
    }
    #[Route('/register', name: 'app_register')]
    public function appRegister(): Response
    {
        return  $this->render('authentication/register.html.twig');
    }

    #[Route("/user/login",name: "userLogin",methods: ['POST'])]
    public function login(Request $request,UserRepository $userRepository)
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
            return $this->redirectToRoute('app_login');
        }
    }
}

