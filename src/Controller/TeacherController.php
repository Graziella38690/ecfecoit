<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\TeacherFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(TeacherFormType::class, $user);
        $form->handleRequest($request);
        $user->setRoles(['ROLE_TEACHERWAIT']);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_wait');
        }

        return $this->render('registration/teacher.html.twig', [
            'teacherForm' => $form->createView(),
        ]);
    }
}