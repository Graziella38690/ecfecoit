<?php

namespace App\Form;
use App\Entity\Lesson;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LessonType extends AbstractType
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { $userId = $this->user;
        $builder
            ->add('Title')
            ->add('textlesson')
            
            ->add('Section', EntityType::class, [
                'label' => 'Attachée à la section:',
                'class' => Section::class,
                'query_builder' => function (EntityRepository $er) use ($userId) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.Creatby = :val')
                        ->setParameter('val', $userId)
                        ->orderBy('e.id', 'ASC');
                },
                'choice_label' => 'title',
            ]);
    }

            
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
