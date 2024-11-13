<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksFormType;
use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TricksController extends AbstractController
{
    #[Route('/{slug}', name: 'app_trick')]
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

    #[Route('/trick/addTrick', name: 'app_newTrick')]
    public function addTrick(Request $request): Response {
        $trick = new Tricks();
        $form = $this->createForm(TricksFormType::class, $trick);
        $form->handleRequest($request);

        return $this->render('tricks/addTrick.html.twig', [
            'controller_name' => 'TricksController',
            'addTrickForm' => $form,
        ]);
    }

    #[Route('/trick/updateTrick/{slug}', name: 'app_updateTrick')]
    public function updateTrick($slug): Response {
        return $this->render('tricks/modify-trick.html.twig', [
            'controller_name' => 'TricksController',
        ]);
    }

    #[Route('/trick/deleteTrick/{slug}', name: 'app_deleteTrick')]
    public function deleteTrick($slug): Response {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
