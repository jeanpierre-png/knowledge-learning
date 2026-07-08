<?php

namespace App\Tests;

use App\Entity\Theme;
use App\Entity\Course;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PurchaseControllerTest extends WebTestCase
{
    public function testAnonymousUserCannotBuyCourse(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');

        $theme = new Theme();
        $theme->setname('Test');

        $course =  new Course();
        $course->setTitle('Curcus test');
        $course->setDescription('Description test');
        $course->setPrice('50.00');
        $course->setTheme($theme);

        $user = new User();
        $user->setEmail('jp-' . uniqid() . '@test.com');
        $user->setRoles(['ROLE_CLIENT']);
        $user->setPassword('password');
        $user->setIsVerified(false);

        $entityManager->persist($theme);
        $entityManager->persist($course);
        $entityManager->persist($user);
        $entityManager->flush();

        $client->request('GET', '/stripe/course/'.$course->getId());

        $this->assertResponseRedirects('/login');
    }
}
