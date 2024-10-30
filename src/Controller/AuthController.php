<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\RegisterFormType;
use App\Form\AuthFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
            'formRegisterUser' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $AuthenticationUtils): Response
    {
        $user = new User();
        $form = $this->createForm(AuthFormType::class, $user);
        $form->handleRequest($request);

        $error = $AuthenticationUtils->getLastAuthenticationError();
        $username = $AuthenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', [
            'controller_name' => 'AuthController',
            'formLoginUser' => $form->createView(),
            'error' => $error,
            '$username' => $username,
        ]);
    }

    #[Route('/forgotPassword', name: 'app_forgot_password')]
    public function forgotPassword(): Response
    {
        return $this->render('auth/forgot-password.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
