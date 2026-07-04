<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class LessonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $lessons = [

            CourseFixtures::COURSE_GUITARE =>[

                [   
                    'title' => "Leçon n°1 : Découverte de l’instrument",
                    'price' => '26.00', 
                    'order' => 1,
                ],
                [   
                    'title' => "Leçon n°2 : Les accords et les gammes",
                    'price' => '26.00', 
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_PIANO =>[

                [   
                    'title' => "Leçon n°1 : Découverte de l’instrument",
                    'price' => '26.00', 
                    'order' => 1,
                ],
                [   
                    'title' => "Leçon n°2 : Les accords et les gammes",
                    'price' => '26.00', 
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_INFORMATIQUE => [

                [
                    'title' => "Leçon n°1 : Les langages Html et CSS",
                    'price' => '32.00', 
                    'order' => 1,
                ],
                [
                    'title' => "Leçon n°2 : Dynamiser votre site avec Javascript",
                    'price' => '32.00', 
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_JARDINAGE => [

                [
                    'title' => "Leçon n°1 : Les outils du jardinier",
                    'price' => '16.00', 
                    'order' => 1,
                ],
                [
                    'title' => "Leçon n°2 : Jardiner avec la lune",
                    'price' => '16.00', 
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_CUISINE => [

                [
                    'title' => "Leçon n°1 : Les modes de cuisson ",
                    'price' => '23.00', 
                    'order' => 1,
                ],
                [
                    'title' => "Leçon n°2 : Les saveurs ",
                    'price' => '23.00', 
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_DRESSAGE => [

                [
                    'title' => "Leçon n°1 : Mettre en œuvre le style dans l’assiette",
                    'price' => '26.00',  
                    'order' => 1,
                ],
                [
                    'title' => "Leçon n°2 : Harmoniser un repas à quatre plats",
                    'price' => '26.00', 
                    'order' => 2,
                ],
            ],
        ];

        foreach ($lessons as $courseReference => $courseLessons) {
            foreach ($courseLessons as $data) {
                $lesson = new Lesson();
                $lesson->setTitle($data['title']);
                $lesson->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
                $lesson->setPrice($data['price']);
                $lesson->setVideoUrl(null);
                $lesson->setOrderIndex($data['order']);
                $lesson->setCourse($this->getReference($courseReference, Course::class));

                $manager->persist($lesson);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ CourseFixtures::class, ];
    }
}
