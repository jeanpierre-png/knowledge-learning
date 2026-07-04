<?php

namespace App\DataFixtures;


use App\Entity\Course;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixtures extends Fixture implements dependentFixtureInterface
{

    public const COURSE_GUITARE = 'course_guitare';
    public const COURSE_PIANO = 'course_piano';
    public const COURSE_INFORMATIQUE = 'course_informatique';
    public const COURSE_JARDINAGE = 'course_jardinage';
    public const COURSE_CUISINE = 'course_cuisine';
    public const COURSE_DRESSAGE = 'course_dressage';

    public function load(ObjectManager $manager): void
    {
      $courses = [
        self::COURSE_GUITARE=> [
          'title' => "Cursus d’initiation à la guitare",
          'price' => '50.00', 
          'theme' => ThemeFixtures::THEME_MUSIQUE,
        ],
        self::COURSE_PIANO => [
          'title' => "Cursus d’initiation au piano",
          'price' => '50.00', 
          'theme' => ThemeFixtures::THEME_MUSIQUE,
        ],

        self::COURSE_INFORMATIQUE => [
          'title' => "Cursus d'initiation au développement web", 
          'price' => '60.00', 
          'theme' => ThemeFixtures::THEME_INFORMATIQUE,
        ],

        self::COURSE_JARDINAGE =>[
          'title' => "Cursus d'initiation au jardinage", 
          'price' => '30.00', 
          'theme' => ThemeFixtures::THEME_JARDINAGE,
        ],

        self::COURSE_CUISINE => [
          'title' => "Cursus d'initiation à la cuisine", 
          'price' => '44.00', 
          'theme' => ThemeFixtures::THEME_CUISINE,
        ],
        self::COURSE_DRESSAGE => [
          'title' => "Cursus d’initiation à l’art du dressage culinaire", 
          'price' => '48.00', 
          'theme' => ThemeFixtures::THEME_CUISINE,
        ],
      ];

      foreach ($courses as $reference => $data) {
        $course = new Course();
        $course->setTitle($data['title']);
        $course->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
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
