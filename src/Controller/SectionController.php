<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


#[Route('/section')]
class SectionController extends AbstractController
{
    #[Route('/', name: 'app_section_index', methods: ['GET'])]
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('section/index.html.twig', [
            'sections' => $sectionRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
            'user' => $this->getUser()
        ]);
    }

    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/new', name: 'app_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SectionRepository $sectionRepository): Response
    {   
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);
        
    
        if ($form->isSubmitted() && $form->isValid()) {
            $section->setCreatby($this->getUser());
            $sectionRepository->add($section);
           return $this->redirectToRoute('app_lesson_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('section/new.html.twig', [
            
            'section' => $section,
            'form' => $form,
       
        ]);
    }

    #[Route('/{id}', name: 'app_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        $lessons = $section->getLessonsContained();
        $training = $section->getContainedIn();
        return $this->render('section/show.html.twig', [
            'training' => $training,
            'section' => $section,
            array ('date' => $lessons)
            
        ]);
    }


    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        if ($section->getCreatby() === $this->getUser()) {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->add($section);
            return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('section/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);

    } else {
        return $this->render('section/index.html.twig', [
            'sections' => $sectionRepository->findBy(['Creatby' => $this->getuser()], ['id' => 'asc']),
            
        ]);
    }
    }
    #[Security("is_granted('ROLE_TEACHER')", statusCode: 404)]
    #[Route('/{id}', name: 'app_section_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            $sectionRepository->remove($section);
        }

        return $this->redirectToRoute('app_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
