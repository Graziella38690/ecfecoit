<?php

namespace App\Form;

use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'maxlength' => 255
                ],
            ])
            
            ->add('isPublished', ChoiceType::class, [
                'choices'  => [
                    'Non' => false,
                    'Oui' => true,

                ],
                'label' => 'Publier'
            ])


            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $Training= $event->getData();
                $form = $event->getForm();
        
                
        
             
                if (!$Training || null === $Training->getId()) {
                    $form
                    ->add('picture', FileType::class, [
                        'label' => 'Image',
                        'label_attr' => [
                            'class' => 'old-rose ',
                        ],
                        'mapped' => false,
                        'constraints' => [
                            new File([
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                ],
                                'mimeTypesMessage' => 'Le fichier doit être au format jpeg, jpg ou png.',
                            ])
                        ],
                    ]);
                
                }
            });
        
            

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
