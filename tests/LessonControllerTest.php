<?php

namespace App\Tests;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Theme;
use App\Entity\User;
use App\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LessonControllerTest extends WebTestCase
{
    public function testUserCannotAccessLessonWithoutPurchase(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');

        // Création du thème
        $theme = new Theme();
        $theme->setName('Développement');

        // Création du cursus
        $course = new Course();
        $course->setTitle('Symfony');
        $course->setDescription('Cours Symfony');
        $course->setPrice('100.00');
        $course->setTheme($theme);

        // Création de la leçon
        $lesson = new Lesson();
        $lesson->setTitle('Introduction');
        $lesson->setContent('Contenu');
        $lesson->setPrice('20.00');
        $lesson->setOrderIndex(1);
        $lesson->setCourse($course);

        // Création d'un utilisateur vérifié
        $user = new User();
        $user->setEmail('lesson-' . uniqid() . '@test.com');;
        $user->setRoles(['ROLE_CLIENT']);
        $user->setPassword('password');
        $user->setIsVerified(true);

        $entityManager->persist($theme);
        $entityManager->persist($course);
        $entityManager->persist($lesson);
        $entityManager->persist($user);

        $entityManager->flush();

        $client->loginUser($user);

        $client->request('GET', '/lesson/' . $lesson->getId());

        $this->assertResponseRedirects('/course/' . $course->getId());
    }

    public function testUserCanAccessPurchasedLesson(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');

        $theme = new Theme();
        $theme->setName('Développement');

        $course = new Course();
        $course->setTitle('Symfony');
        $course->setDescription('Cours Symfony');
        $course->setPrice('100.00');
        $course->setTheme($theme);

        $lesson = new Lesson();
        $lesson->setTitle('Introduction');
        $lesson->setContent('Contenu');
        $lesson->setPrice('20.00');
        $lesson->setOrderIndex(1);
        $lesson->setCourse($course);

        $user = new User();
        $user->setEmail('lesson-' . uniqid() . '@test.com');;
        $user->setRoles(['ROLE_CLIENT']);
        $user->setPassword('password');
        $user->setIsVerified(true);

        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setCourse(null);
        $purchase->setLesson($lesson);
        $purchase->setPrice($lesson->getPrice());
        $purchase->setStatus('PAID');
        $purchase->setPurchasedAt(new \DateTimeImmutable());

        $entityManager->persist($theme);
        $entityManager->persist($course);
        $entityManager->persist($lesson);
        $entityManager->persist($user);
        $entityManager->persist($purchase);
        $entityManager->flush();

        $client->loginUser($user);

        $client->request('GET', '/lesson/' . $lesson->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Introduction');
    }
}