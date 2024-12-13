<?php

namespace App\Controller;

use App\Form\UserUpdateDataFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
    #[Route('/user', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/user/updateUser', name: 'app_updateUser')]
    public function updateUser(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserUpdateDataFormType::class, $user);
        $form->handleRequest($request);

        return $this->render('users/modify-profil.html.twig', [
            'controller_name' => 'UsersController',
            'formUpdateUser' => $form->createView(),
        ]);
    }

    #[Route('/user/profil', name: 'app_profilUser')]
    public function profilUser(): Response
    {
        return $this->render('users/profil-user.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/user/modifyPassword', name: 'app_modifyPassword')]
    public function modifyPassword(): Response
    {
        return $this->render('users/modify-password.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
