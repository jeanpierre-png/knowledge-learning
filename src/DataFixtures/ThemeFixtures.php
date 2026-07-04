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
            
            self::THEME_MUSIQUE => ['name' => 'Musique'],
            self::THEME_INFORMATIQUE => ['name' => 'Informatique'],
            self::THEME_JARDINAGE =>['name' => 'Jardinage'],
            self::THEME_CUISINE => ['name' => 'Cuisine'],      
        ];

        foreach ($themes as $reference => $data) {
            $theme = new Theme();
            $theme->setName($data['name']);

            $manager->persist($theme);
            $this->addReference($reference, $theme);
        }

        $manager->flush();
    }
}
