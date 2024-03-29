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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends AbstractController
{   #[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
    #[Route("/admin/list/teacher", name:"app_list_teacher")]
 
    public function listteacher(UserRepository $repository): Response
{
        $user = $repository -> getAllTeacher();
    
    return $this->render('admin/teacherlist.html.twig', [
        'user'=> $user
    ]);
}
#[Security("is_granted('ROLE_ADMIN')", statusCode: 404)]
#[Route("/admin/list/laerning", name:"app_list_laerning")]
 
    public function listlaerning(UserRepository $repository): Response
{
        $user = $repository -> getAllLaerning();
    
    return $this->render('admin/laerninglist.html.twig', [
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
            return $this->redirectToRoute('app_admin');
        }

          
            

            return $this ->render('admin/useredit.html.twig',[
                'user'=> $user, 'form' => $form->createView()]);
    }



}