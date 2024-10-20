<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/users/updateUser', name: 'app_updateUser')]
    public function updateUser(): Response
    {
        return $this->render('users/modify-profil.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/users/modifyPassword', name: 'app_modifyPassword')]
    public function modifyPassword(): Response
    {
        return $this->render('users/modify-password.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
