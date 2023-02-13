<?php
namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TrainingController extends AbstractController
{  
    #[Route('training/index', name: 'app_training_index', methods: ['GET'])]
    public function index(Request $request,TrainingRepository $TrainingRepository, PaginatorInterface $paginator): Response
    {   
        $Training = $TrainingRepository->findAll();
        $Training = $paginator->paginate(
            $Training, 
            $request->query->getInt('page', 1), 
            limit:6
        );
        
        return $this->render('training/index.html.twig', [
            'trainings' => $Training,
            
            'user' => $this->getUser()
        ]);
    }
  
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('training/new', name: 'app_training_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrainingRepository $TrainingRepository,FileUploader $FileUploader): Response
    {
        $Training = new Training();
        $form = $this->createForm(TrainingType::class, $Training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Training->setCreatby($this->getUser());
            
            if ($form->get('isPublished')->getData()) {
                $Training->setDatecreate(new DateTimeImmutable());
            }
            
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $pictureFileName = $FileUploader->UploadFile($pictureFile);
                $Training->setPicture($pictureFileName);
            }
            $TrainingRepository->add($Training);
            return $this->redirectToRoute('app_teacher_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('training/new.html.twig', [
            'training' => $Training,
            'form' => $form,
           
        ]);
    }
    #[Security("is_granted('ROLE_LAERNING')", statusCode: 404)]
    #[Route('training/show/{id}', name: 'app_training_show', methods: ['GET'])]
   
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
    #[Route('training/{id}/edit', name: 'app_training_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Training $Training, TrainingRepository $TrainingRepository): Response
    {
        $form = $this->createForm(TrainingType::class, $Training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUser();
            $Training->setCreatby($this->getUser());
            $TrainingRepository->add($Training);
            return $this->redirectToRoute('app_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('training/edit.html.twig', [
            'training' => $Training,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('training/delete/{id}', name: 'app_training_delete', methods: ['POST'])]
    public function delete(Request $request, Training $Training, TrainingRepository $TrainingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Training->getId(), $request->request->get('_token'))) {
            $TrainingRepository->remove($Training);
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
