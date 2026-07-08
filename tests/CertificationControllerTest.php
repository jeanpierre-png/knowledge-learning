<?php

namespace App\Tests;

use App\Entity\Certification;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\LessonProgress;
use App\Entity\Purchase;
use App\Entity\Theme;
use App\Entity\User;
use App\Repository\CertificationRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CertificationControllerTest extends WebTestCase
{
    public function testCertificationIsCreatedWhenLastLessonIsValidated(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');

        // Thème
        $theme = new Theme();
        $theme->setName('Développement');

        // Cursus
        $course = new Course();
        $course->setTitle('Symfony');
        $course->setDescription('Cours Symfony');
        $course->setPrice('100.00');
        $course->setTheme($theme);

        // Première leçon
        $lesson1 = new Lesson();
        $lesson1->setTitle('Introduction');
        $lesson1->setContent('...');
        $lesson1->setPrice('20.00');
        $lesson1->setOrderIndex(1);
        $lesson1->setCourse($course);

        // Deuxième leçon
        $lesson2 = new Lesson();
        $lesson2->setTitle('Doctrine');
        $lesson2->setContent('...');
        $lesson2->setPrice('20.00');
        $lesson2->setOrderIndex(2);
        $lesson2->setCourse($course);

        // Utilisateur
        $user = new User();
        $user->setEmail('certification-' . uniqid() . '@test.com');
        $user->setPassword('password');
        $user->setRoles(['ROLE_CLIENT']);
        $user->setIsVerified(true);

        // Achat du cursus
        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setCourse($course);
        $purchase->setLesson(null);
        $purchase->setPrice($course->getPrice());
        $purchase->setStatus('PAID');
        $purchase->setPurchasedAt(new \DateTimeImmutable());

        // Première leçon déjà validée
        $progress = new LessonProgress();
        $progress->setUser($user);
        $progress->setLesson($lesson1);
        $progress->setValidated(true);
        $progress->setValidatedAt(new \DateTimeImmutable());

        $entityManager->persist($theme);
        $entityManager->persist($course);
        $entityManager->persist($lesson1);
        $entityManager->persist($lesson2);
        $entityManager->persist($user);
        $entityManager->persist($purchase);
        $entityManager->persist($progress);

        $entityManager->flush();

        $client->loginUser($user);

        // Validation de la dernière leçon
        $client->request('GET', '/lesson/' . $lesson2->getId() . '/validate');

        $this->assertResponseRedirects('/lesson/' . $lesson2->getId());

        /** @var CertificationRepository $repository */
        $repository = static::getContainer()->get(CertificationRepository::class);

        $certification = $repository->findOneBy([
            'user' => $user,
            'course' => $course,
        ]);

        $this->assertNotNull($certification);
        $this->assertInstanceOf(Certification::class, $certification);
    }
}