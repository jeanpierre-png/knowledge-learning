<?php

namespace App\Tests;

use App\Entity\Certification;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\LessonProgress;
use App\Entity\Purchase;
use App\Entity\Theme;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{
    public function testRepositoriesAreAvailable(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->assertNotNull($container->get('doctrine')->getRepository(User::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(Theme::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(Course::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(Lesson::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(Purchase::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(LessonProgress::class));
        $this->assertNotNull($container->get('doctrine')->getRepository(Certification::class));
    }
}