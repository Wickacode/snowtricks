<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TricksController extends AbstractController
{
    #[Route('/trick', name: 'app_trick')]
    public function showTrick(): Response
    {
        return $this->render('tricks/trick.html.twig', [
            'controller_name' => 'TricksController',
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
