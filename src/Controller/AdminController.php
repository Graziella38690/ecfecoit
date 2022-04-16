<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route("/admin/list/user", name:"app_list_user")]
 
public function listeuser(UserRepository $repository): Response
{
        $user = $repository -> findAll();
    
    return $this->render('admin/userlist.html.twig', [
        'user'=> $user
    ]);
}
#[Route("/admin/profil/user/{id}", name:"app_profil_user")]
 
public function profiluser(UserRepository $repository, int $id): Response
{
        $user = $repository -> findBy(['id' => $id]);
    
    return $this->render('admin/userprofil.html.twig', [
        'user'=> $user
    ]);
}



#[Route('/admin/edit/user/{id}', name:'app_edit_user', methods: ['GET', 'POST'])]
    public function edituser(User $user, Request $request, EntityManagerInterface $manager): Response 
    {
       
        
            $form = $this->createForm(UserType::class,$user);
            $form ->handleRequest($request);
            if ($form->isSubmitted()&& $form->isValid()){
                $user = $form->getData();
                $manager ->persist($user);
                $manager ->flush();

                $this->addFlash(
                    'Félicitation',
                    'Votre utilisateur a été modifié avec succès !'
                );
            return $this->redirectToRoute('app_list_user');
        }

            return $this ->render('admin/useredit.html.twig',[
                'user'=> $user, 'form' => $form->createView()]);
    }



}