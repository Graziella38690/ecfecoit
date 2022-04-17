<?php

namespace App\DataFixtures;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Entity\Training;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    /**
     
     *
     * @var Generator
     */
    private Generator $faker;
    public function __construct()
    {
        $this ->faker = Factory::create('fr_FR');
    }
    

        
    
    public function load(ObjectManager $manager): void
    { 


        //Fixtures user
       



        // Fixtures lessons
        $lessons = [];
        for ($i = 0; $i < 20; $i++) {
            $lesson = new Lesson();
            $lesson->setTitle($this->faker->word());
            $lesson->settextlesson($this->faker->text(500));
           $lessons[]=$lesson;
            $manager->persist($lesson);
        }

        
    
        //Fixtures sections
        $sections = [];
        for ($j = 0; $j <20; $j++) {
            $section = new Section();
            $section->setTitle($this->faker->word());
        

        for ($k=0;$k< mt_rand(5,8); $k++){

        $section->addLesson($lessons[mt_rand(0,count($lessons)-1)]);
        }
            $sections[]=$section;
            $manager->persist($section);
        }


        //Fixtures training
        for ($l = 0; $l < 20; $l++) {
            $training = new Training();
            $training->setTitle($this->faker->text(100));
            $training->setDescription($this->faker->text(300));
            $training->setCatchphrase($this->faker->text(100));

            for ($m=0;$m< mt_rand(5,8); $m++){
            $training->addSection($sections[mt_rand(0,count($sections)-1)]);

        }
            $manager->persist($training);
    
        }

        $manager->flush();
    }
    }
   


    











   