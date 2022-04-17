<?php

namespace App\Controller;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TrainingRepository $trainingRepository): Response
    {   
        
        return $this->render('home/index.html.twig', [
            'trainings' => $trainingRepository->findLastTraining(),
        ]);
    }



    #[Route('/wait', name: 'app_wait')]
    public function wait(): Response
    {
        return $this->render('home/wait.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    
}
