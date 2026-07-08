<?php

namespace App\Tests;

use App\Entity\Course;
use App\Entity\Theme;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected function getEntityManager(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function createTheme(string $name = 'Thème test'): Theme
    {
        $theme = new Theme();
        $theme->setName($name);

        $this->getEntityManager()->persist($theme);

        return $theme;
    }

    protected function createCourse(?Theme $theme = null): Course
    {
        $theme ??= $this->createTheme();

        $course = new Course();
        $course->setTitle('Cursus test');
        $course->setDescription('Description test');
        $course->setPrice('50.00');
        $course->setTheme($theme);

        $this->getEntityManager()->persist($course);

        return $course;
    }

    protected function createUser(
        string $email = 'user-test@example.com',
        bool $isVerified = true,
        array $roles = ['ROLE_CLIENT']
    ): User {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword('password');
        $user->setIsVerified($isVerified);

        $this->getEntityManager()->persist($user);

        return $user;
    }

    protected function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}