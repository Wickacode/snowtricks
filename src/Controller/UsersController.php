<?php

namespace App\Controller;

use App\Form\UserUpdateDataFormType;
use App\Form\UserUpdatePassFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersController extends AbstractController
{
    #[Route('/user/profile', name: 'app_profilUser', methods: ['GET'])]
    public function profileUser(): Response
    {
        return $this->render('users/profil-user.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/user/updateUser', name: 'app_updateUser', methods: ['GET', 'POST'])]
    public function updateUser(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $precedentAvatar = $user->getAvatar();
        $form = $this->createForm(UserUpdateDataFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newAvatar = $form->get('avatar')->getData();
            $dateUpdateUser = new \DateTime();
            $user->setDateUpdateUser($dateUpdateUser);

            if ($newAvatar !== null) {
                $originalAvatar = pathinfo($newAvatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeAvatar = $slugger->slug($originalAvatar);
                $avatarFilename = 'img/upload/avatars/' . $safeAvatar . '-' . uniqid() . '.' . $newAvatar->guessExtension();

                try {
                    $newAvatar->move(
                        $this->getParameter('images_directory'),
                        $avatarFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'avatar.');
                }

                $user->setAvatar($avatarFilename);
            } else {
                if ($precedentAvatar !== null) {
                    $user->setAvatar($precedentAvatar);
                } else {
                    $user->setAvatar(''); // Avatar par défaut ou gestion personnalisée
                }
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');
            return $this->redirectToRoute('app_profilUser');
        }

        return $this->render('users/modify-profil.html.twig', [
            'controller_name' => 'UsersController',
            'formUpdateUser' => $form->createView(),
        ]);
    }

    #[Route('/user/modifyPassword', name: 'app_modifyPassword', methods: ['GET', 'POST'])]
    public function modifyPassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre mot de passe.');
        }

        $form = $this->createForm(UserUpdatePassFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualPassword = $form->get('actualPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmNewPassword = $form->get('confirmNewPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $actualPassword)) {
                $error = $this->addFlash('error', 'Ancien mot de passe incorrect.');
                return $this->redirectToRoute('app_modifyPassword', [
                    'error' => $error,
                ]);
            }

            if ($newPassword !== $confirmNewPassword) { 
                $error = $this->addFlash('error', 'Le nouveau mot de passe et sa confirmation ne correspondent pas.');
                return $this->redirectToRoute('app_modifyPassword',
                [
           'error' => $error,         
                ]);
            
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager->flush();
            
            $succes = $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
            return $this->redirectToRoute('app_profilUser', [
                'succes' => $succes,
            ]);
        }

        return $this->render('users/modify-password.html.twig', [
            'controller_name' => 'UsersController',
            'form' => $form->createView()
        ]);
    }
}
