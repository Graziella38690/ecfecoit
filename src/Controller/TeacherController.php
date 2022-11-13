<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\TrainingType;
use App\Repository\SectionRepository;
use App\Repository\TrainingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class TeacherController extends AbstractController
{
   
#[Route('/teacher', name: 'app_teacher_index', methods: ['GET'])]
 
public function details(TrainingRepository $TrainingRepository): Response
{
    /** @var User $user */
    $user = $this->getUser();
    return $this->render('teacher/index.html.twig', [
        'training' => $TrainingRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
        
        
    ]);
    
}


    #[Route('/show', name: 'app_teacher_show', methods: ['GET'])]

    public function index(TrainingRepository $TrainingRepository): Response
    {
        return $this->render('teacher/show.html.twig', [
            'trainings' => $TrainingRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
        ]);
    }
}
