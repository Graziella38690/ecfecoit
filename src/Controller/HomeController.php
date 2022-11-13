<?php

namespace App\Controller;
use app\Entity\User;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/index', name: 'app_home')]
    public function index(TrainingRepository $TrainingRepository): Response
    {   
       
        return $this->render('home/index.html.twig', [
            'Trainings' => $TrainingRepository->findLastTraining(),
        ]);
    }


    
}
