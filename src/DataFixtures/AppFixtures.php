<?php

namespace App\DataFixtures;
use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Entity\Training;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class AppFixtures extends Fixture
{
    /**
     
     *
     * @var Generator
     */
    private Generator $faker;


    private UserPasswordHasherInterface $hasher;

    



    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this ->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    

        
    
    public function load(ObjectManager $manager): void
    { 


        //Fixtures user
       
        
            $user = new User();
            $user->setFirstname('John');
            $user->setLastname('do');
            $user->setSpecialities('blablablablabla');
            $user->setPseudo('JJ');
            $user->setEmail('Johndo@outlook.fr');
            $user->setRoles (["ROLE_TEACHER"]
        );
            

    
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setPassword($password);
    
            $manager->persist($user);
    
        
    


        // Fixtures lessons
        $lessons = [];
        for ($i = 0; $i < 50; $i++) {
            $lesson = new Lesson();
            $lesson->setTitle($this->faker->word());
            $lesson->settextlesson($this->faker->text(500));
            $lessons[]=$lesson;
            $manager->persist($lesson);
        }

        
    
        //Fixtures sections
        $sections = [];
        for ($j = 0; $j <60; $j++) {
            $section = new Section();
            $section->setTitle($this->faker->word());
        

        for ($k=0;$k< mt_rand(1,8); $k++){

        $section->addLesson($lessons[mt_rand(0,count($lessons)-1)]);
        }
            $sections[]=$section;
            $manager->persist($section);
        }


        //Fixtures training
        for ($l = 0; $l < 10; $l++) {
            $training = new Training();
            $training->setTitle($this->faker->text(50));
            $training->setDescription($this->faker->paragraph());
            $training->setCatchphrase($this->faker->text(100));
            $training->setCreatby($user);
            for ($m=0;$m< mt_rand(1,8); $m++){
            $training->addSection($sections[mt_rand(0,count($sections)-1)]);

        }
            $manager->persist($training);
    
        }

        $manager->flush();
    }
    }
   


    











   