<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PhotoprofileType;
use App\Form\ProfiletFormType;
use App\Form\ProfileFormType;
use App\Form\ProfilelFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

class ProfileController extends AbstractController
{  

    #[Route('/profile/index/{id}', name: 'app_profile_index',methods: ['GET','POST'])]
    public function index(User $user, Request $request,EntityManagerInterface $manager ,FileUploader $FileUploader): Response
    {

        if(!$this->getUser()) {
            return $this ->redirectToRoute('app_login');
}
        if($this->getUser() !== $user) {
    return $this ->redirectToRoute('app_home');
}

        $form = $this->createForm(ProfileFormType::class,$user);
        $form = $form->handleRequest($request);
        if($form ->isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
            $manager->persist($user);
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $photoFileName = $FileUploader->UploadFile($photoFile);
                $user->setPhoto($photoFileName);
            }

            

return $this->redirectToRoute('app_home');
        } 
        
            
        

        return $this->render('profile/index.html.twig', [
            'form' => $form -> createView(),
        ]);
    }


    #[Route('/profile/editiont/{id}', name: 'app_profile_editt',methods: ['GET','POST'])]
    public function editT(User $user,UserRepository $userRepository, Request $request,EntityManagerInterface $manager ): Response
    {

        if(!$this->getUser()) {
            return $this ->redirectToRoute('app_login');
}
        if($this->getUser() !== $user) {
    return $this ->redirectToRoute('app_home');
}

    $form = $this->createForm(ProfiletFormType::class,$user,array());
    $form = $form->handleRequest($request);

        if($form ->isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
          
            $userRepository->add($user); 
    return $this->redirectToRoute('app_profile_index',[
    'id'=>$user->getId(),
 
]);

        } 
        return $this->render('profile/edit.html.twig', [
           
            'form' => $form -> createView(),
         
        ]);
    }




    #[Route('/profile/editionl/{id}', name: 'app_profile_editl',methods: ['GET','POST'])]
    public function editL(User $user,UserRepository $userRepository, Request $request,EntityManagerInterface $manager ): Response
    {

        if(!$this->getUser()) {
            return $this ->redirectToRoute('app_login');
}
        if($this->getUser() !== $user) {
    return $this ->redirectToRoute('app_home');
}

    $form = $this->createForm(ProfilelFormType::class,$user,array());
    $form = $form->handleRequest($request);

        if($form ->isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
          
            $userRepository->add($user); 
    return $this->redirectToRoute('app_profile_index',[
    'id'=>$user->getId(),
 
]);

        } 
        return $this->render('profile/edit.html.twig', [
           
            'form' => $form -> createView(),
         
        ]);
    }






    #[Route('/profile/edition/photo/{id}', name: 'app_profile_edit_photo',methods: ['GET','POST'])]
    public function editphoto(User $user, UserRepository $userRepository, Request $request,EntityManagerInterface $manager ,FileUploader $FileUploader): Response
    {

        if(!$this->getUser()) {
            return $this ->redirectToRoute('app_login');
}
        if($this->getUser() !== $user) {
    return $this ->redirectToRoute('app_home');
}

        $form = $this->createForm(PhotoprofileType::class,$user);
        $form = $form->handleRequest($request);
        if($form ->isSubmitted() && $form->isValid()) {
            $user = $form -> getData();
            $manager->persist($user);
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $photoFileName = $FileUploader->UploadFile($photoFile);
                $user->setPhoto($photoFileName);
            }
            $userRepository->add($user);        
return $this->redirectToRoute('app_profile_index',[
    'id'=>$user->getId()
]);

        } 
        return $this->render('profile/editphoto.html.twig', [
            'form' => $form -> createView(),
        ]);
    }

}
