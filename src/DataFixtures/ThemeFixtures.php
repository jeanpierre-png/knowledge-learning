<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ThemeFixtures extends Fixture
{

    public const THEME_MUSIQUE = 'theme_musique';
    public const THEME_INFORMATIQUE = 'theme_informatique';
    public const THEME_JARDINAGE = 'theme_jardinage';
    public const THEME_CUISINE = 'theme_cuisine';


    public function load(ObjectManager $manager): void
    {
        $themes = [
            self::THEME_MUSIQUE => ['name' => 'Musique', 'description' => 'Formations autour des instruments et la pratique musicale.',],
            self::THEME_INFORMATIQUE => ['name' => 'Informatique', 'description' =>  'Formations autour du développement web et web mobile.',],
            self::THEME_JARDINAGE =>['name' => 'Jardinage', 'description' => 'Formations pour apprendre les base du jardinage.',],
            self::THEME_CUISINE => ['name' => 'Cuisine', 'description' => 'Formations autour des technique culinaires.',],
        ];

        foreach ($themes as $reference => $data) {
            $theme = new Theme();
            $theme->setName($data['name']);
            $theme->setDescription($data['description']);

            $manager->persist($theme);
            $this->addReference($reference, $theme);
        }

        $manager->flush();
    }
}
