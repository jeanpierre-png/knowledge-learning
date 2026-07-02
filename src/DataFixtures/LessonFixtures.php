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

            CourseFixtures::COURSE_MUSIQUE =>[

                [   
                    'title' => "Découverte de l'instrument",
                    'content' => "Origine.",
                    'order' => 1,
                ],
                [   
                    'title' => "Découverte de l'instrument",
                    'content' => "Le premier instrument.",
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_INFORMATIQUE => [

                [
                    'title' => "Les langages HTLM et CSS",
                    'content' => "Découverte des bases.",
                    'order' => 1,
                ],
                [
                    'title' => "Dynamiser votre site web avec Javascript",
                    'content' => "Introduction à Javascript.",
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_JARDINAGE => [

                [
                    'title' => "Les outils essentiels du jardinier",
                    'content' => "Présentation de ces principaux outils.",
                    'order' => 1,
                ],
                [
                    'title' => "Jardinier au rythme des saisons",
                    'content' => "Comprendre les principes du jardinage.",
                    'order' => 2,
                ],
            ],

            CourseFixtures::COURSE_CUISINE => [

                [
                    'title' => "Association des couleurs",
                    'content' => "Découverte des saveurs et des mariages.",
                    'order' => 1,
                ],
                [
                    'title' => "Techniques de maintien",
                    'content' => "Découvrir comment tenir un couteau.",
                    'order' => 2,
                ],
            ],
        ];

        foreach ($lessons as $courseReference => $courseLessons) {
            foreach ($courseLessons as $data) {
                $lesson = new Lesson();
                $lesson->setTitle($data['title']);
                $lesson->setContent($data['content']);
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
