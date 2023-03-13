<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
class TeacherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('pseudo')
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('specialities')
            ->add('photo', FileType::class, [
                'label' => 'Photo',
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
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'vous devez acepter les conditions d\'utilisation',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site j\'accepte...'
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                       
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                    new Regex([
                        // password must have a lower case letter, an upper case letter and a number. Minimum length is 6.
                        'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$/',
                        'message' => 'Le mot de passe ne doit pas être inférieur à 6 caractères et il doit contenir au moins une minuscule, une majuscule et un chiffre'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
