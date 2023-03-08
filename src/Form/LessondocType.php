<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LessondocType extends AbstractType
{
    
    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        

        $builder

        
           
            
      

            ->add('resources', FileType::class, [
                'label' => 'Document(s)',
                'multiple' => true,
                'label_attr' => [
                    'class' => 'old-rose ',
                ],
                'mapped' => false,

                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'application/pdf'
                                ],
                                'mimeTypesMessage' => 'Le fichier doit être au format pdf, jpeg, jpg ou png.',
                            ])
                        ]
                    ])
                ],
            ]);











            
    }

            
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}

    