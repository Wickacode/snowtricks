<?php

namespace App\Controller;

use App\Repository\TricksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function index(TricksRepository $trickRepository ): Response
    {
        $tricks = $trickRepository->findAll();
        
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
        ]);
    }
}
