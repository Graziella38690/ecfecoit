<?php

namespace App\Controller;

use App\Entity\Training;

use App\Form\TrainingType;
use App\Repository\SectionRepository;
use App\Repository\TrainingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


#[Route('/training')]

class TrainingController extends AbstractController
{  
    #[Route('/', name: 'app_training_index', methods: ['GET'])]
    public function index(Request $request,TrainingRepository $trainingRepository, PaginatorInterface $paginator): Response
    {   
        $Training = $trainingRepository->findAll();
        $Training = $paginator->paginate(
            $Training, 
            $request->query->getInt('page', 1), 
            limit:6
        );
        
        return $this->render('training/index.html.twig', [
            'trainings' => $Training,
        ]);
    }
  
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/new', name: 'app_training_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrainingRepository $trainingRepository): Response
    {
        $Training = new Training();
        
       
        $form = $this->createForm(TrainingType::class, $Training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getUser();
            $Training->setCreatby($this->getUser());
         
            $trainingRepository->add($Training);
            return $this->redirectToRoute('app_teacher_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('training/new.html.twig', [
            'training' => $Training,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_LAERNING')", statusCode: 404)]
    #[Route('/{id}', name: 'app_training_show', methods: ['GET'])]
   
    public function show(training $Training ): Response
    {  

        $sections = $Training->getSections();

        return $this->render('training/show.html.twig',
         [
            'training' => $Training,
            array ('date' => $sections)
        ]);
    }
   
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/{id}/edit', name: 'app_training_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Training $Training, TrainingRepository $trainingRepository): Response
    {
        $form = $this->createForm(TrainingType::class, $Training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trainingRepository->add($Training);
            return $this->redirectToRoute('app_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training/edit.html.twig', [
            'training' => $Training,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/{id}', name: 'app_training_delete', methods: ['POST'])]
    public function delete(Request $request, Training $training, TrainingRepository $trainingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $trainingRepository->remove($training);
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
