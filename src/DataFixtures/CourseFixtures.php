<?php

namespace App\DataFixtures;


use App\Entity\Course;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixtures extends Fixture implements dependentFixtureInterface
{

    public const COURSE_MUSIQUE = 'course_musique';
    public const COURSE_INFORMATIQUE = 'course_informatique';
    public const COURSE_JARDINAGE = 'course_jardinage';
    public const COURSE_CUISINE = 'course_cuisine';

    public function load(ObjectManager $manager): void
    {
      $courses = [
        self::COURSE_MUSIQUE => [
          'title' => "Cursus d'initiation à un instrument de musique",
          'description' => "Apprendre les bases d'un instrument.",
          'price' => '70.00', 
          'theme' => ThemeFixtures::THEME_MUSIQUE,
        ],

        self::COURSE_INFORMATIQUE => [
          'title' => "Cursus d'initiation au développement web et web mobile", 
          'description' => "Découvrir l'écosystème du codage.",
          'price' => '50.00', 
          'theme' => ThemeFixtures::THEME_INFORMATIQUE,
        ],

        self::COURSE_JARDINAGE =>[
          'title' => "Cursus d'initiation au jardinage", 
          'description' => "Apprendre les bases du jardinage.",
          'price' => '30.00', 
          'theme' => ThemeFixtures::THEME_JARDINAGE,
        ],

        self::COURSE_CUISINE => [
          'title' => "Cursus d'initiation à la cuisine", 
          'description' => "Découvrir les bases de la cuisine.",
          'price' => '90.00', 
          'theme' => ThemeFixtures::THEME_CUISINE,
        ],
      ];

      foreach ($courses as $reference => $data) {
        $course = new Course();
        $course->setTitle($data['title']);
        $course->setDescription($data['description']);
        $course->setPrice($data['price']);
        $course->setImage(null);
        $course->setTheme($this->getReference($data['theme'], Theme::class));

        $manager->persist($course);
        $this->addReference($reference, $course);
      }

      $manager->flush();

    }

    public function getDependencies(): array
    {
        return [ ThemeFixtures::class, ];
    }
}
