<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TricksController extends AbstractController
{
    #[Route('/trick/{id}', name: 'app_trick')]
    public function showTrick($id, TricksRepository $trickRepository, CommentsRepository $commentsRepository): Response
    {
        $trick = $trickRepository->findOneById($id);
        $comments = $commentsRepository->findByTricks($id);

        return $this->render('tricks/trick.html.twig', [
            'controller_name' => 'TricksController',
            'trick' => $trick,
            'comments' => $comments,
        ]);
    }

    #[Route('/trick/updateTrick/{id}', name: 'app_updateTrick')]
    public function updateTrick($id): Response {
        return $this->render('tricks/modify-trick.html.twig', [
            'controller_name' => 'TricksController',
        ]);
    }

    #[Route('/trick/deleteTrick/{id}', name: 'app_deleteTrick')]
    public function deleteTrick($id): Response {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
