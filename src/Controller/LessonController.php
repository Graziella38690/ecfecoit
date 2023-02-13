<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\LessonRepository;
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
            
        ]);
    }
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/lesson/new', name: 'app_lesson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LessonRepository $lessonRepository): Response
    {   
        $lesson = new Lesson();

        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getUser();
            $lesson->setCreatby($this->getUser());

            $lessonRepository->add($lesson);
            return $this->redirectToRoute('app_lesson_index', [], Response::HTTP_SEE_OTHER);
        }

        

        return $this->renderForm('lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
        ]);
    }

    #[Route('lesson/show/{id}', name: 'app_lesson_show', methods: ['GET'])]
    public function show(lessonRepository $lessonRepository): Response
    {
        return $this->render('lesson/show.html.twig', [
            'lessons' => $lessonRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
        ]);
    }

    #[Route('lesson/{id}/edit', name: 'app_lesson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lesson $lesson, LessonRepository $lessonRepository): Response
    {
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
