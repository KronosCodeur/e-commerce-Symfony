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


    #[Route("/user/register", name: "userRegister", methods: ['POST'])]
    public function register(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');

        // Vérifiez si un utilisateur avec cet e-mail existe déjà
        $existingUser = $userRepository->findOneBy(['email' => $email]);

        if ($existingUser !== null) {
            $this->addFlash('error', 'User with this email already exists.');
            return $this->redirectToRoute('app_register');
        }

        // Créez un nouvel utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setNom($nom);
        $user->setPrenom($prenom);

        // Encodez le mot de passe avant de le stocker
        $encodedPassword = $passwordEncoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        // Enregistrez l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', ['data' => $user]);
    }

}

