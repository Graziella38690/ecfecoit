<?php

namespace App\Controller;


use App\Entity\Lesson;
use App\Form\LessonType;
use App\Form\LessondocType;
use App\Repository\LessonRepository;
use App\Repository\TrainingRepository;
use App\Service\ResourcesUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class LessonController extends AbstractController
{
    #[Route('/lesson/index', name: 'app_lesson_index', methods: ['GET', 'POST'])]
    public function index(LessonRepository $lessonRepository): Response
    
    {
       
        return $this->render('lesson/index.html.twig', [

            'lessons' => $lessonRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
            'user' => $this->getUser()
        ]);
    }
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/lesson/new', name: 'app_lesson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LessonRepository $lessonRepository,ResourcesUploader $ResourcesUploader): Response
    {   
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setCreatby($this->getUser());
            $resourcesFile = $form->get('resources')->getData();
      
            if ($resourcesFile) {
                $resourcesFileName = $ResourcesUploader->UploadFile($resourcesFile);
                $lesson->setRessources($resourcesFileName);
            }
            
            
            
            $lessonRepository->add($lesson);
            return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }




    #[Route('lesson/show/{id}', name: 'app_lesson_show', methods: ['GET'])]
    public function show(lesson $lesson): Response
    {
        $section = $lesson->getContainedIn();
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
            'section' => $section
            
        ]);
    }



    #[Route('lesson/{id}/edit', name: 'app_lesson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lesson $lesson, LessonRepository $lessonRepository,TrainingRepository $trainingRepository, ResourcesUploader $ResourcesUploader): Response
    {
        if ($lesson->getCreatby() === $this->getUser()) {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $lessonRepository->add($lesson);
            return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);

    } else {
        return $this->render('home/index.html.twig', [
            'courses' => $trainingRepository->findLastTraining(),
            'student' => $this->getUser()
        ]);
    }
}
#[Route('lesson/{id}/editdoc', name: 'app_lesson_editdoc', methods: ['GET', 'POST'])]
public function editdoc(Request $request, Lesson $lesson, LessonRepository $lessonRepository,TrainingRepository $trainingRepository, ResourcesUploader $ResourcesUploader): Response
{
    if ($lesson->getCreatby() === $this->getUser()) {
    $form = $this->createForm(LessondocType::class, $lesson);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
            
            
        $resourcesFile = $form->get('resources')->getData();
        if ($resourcesFile) {
            $resourcesFileName = $ResourcesUploader->UploadFile($resourcesFile);
            $lesson->setRessources($resourcesFileName);
        }
        $lessonRepository->add($lesson);
        return $this->redirectToRoute('app_lesson_edit', ['id'=>$lesson->getId()], Response::HTTP_SEE_OTHER);
    }
    return $this->renderForm('lesson/editdoc.html.twig', [
        'lesson' => $lesson,
        'form' => $form,
    ]);

} else {
    return $this->render('home/index.html.twig', [
        'training' => $trainingRepository->findLastTraining(),
        'users' => $this->getUser()
    ]);
}
}

    

    #[Route('lesson/delete/{id}', name: 'app_lesson_delete', methods: ['POST'])]
    public function delete(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $lessonRepository->remove($lesson);
        }

        return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
    }
}
