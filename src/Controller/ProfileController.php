<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/edition/{id}', name: 'app_profile',methods: ['GET','POST'])]
    public function edit(User $user, Request $request,EntityManagerInterface $manager ): Response
    {

        if(!$this->getUser()) {
            return $this ->redirectToRoute('app_login');
}
        if($this->getUser() !== $user) {
    return $this ->redirectToRoute('app_home');
}

        $form = $this->createForm(ProfileType::class,$user);
        $form = $form->handleRequest($request);
        if($form ->isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
            $manager->persist($user);
           



return $this->redirectToRoute('app_home');
        } 
        
            
        

        return $this->render('profile/edit.html.twig', [
            'form' => $form -> createView(),
        ]);
    }
}
