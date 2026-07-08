<?php

namespace App\Tests;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Theme;
use App\Entity\User;
use App\Repository\LessonProgressRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LessonProgressControllerTest extends WebTestCase
{
    public function testUserCanValidateLesson(): void
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
        $user->setEmail('progress-' . uniqid() . '@test.com');
        $user->setRoles(['ROLE_CLIENT']);
        $user->setPassword('password');
        $user->setIsVerified(true);

        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setLesson($lesson);
        $purchase->setCourse(null);
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

        $client->request('GET', '/lesson/' . $lesson->getId() . '/validate');

        $this->assertResponseRedirects('/lesson/' . $lesson->getId());

        /** @var LessonProgressRepository $repository */
        $repository = static::getContainer()->get(LessonProgressRepository::class);

        $progress = $repository->findOneBy([
            'user' => $user,
            'lesson' => $lesson,
        ]);

        $this->assertNotNull($progress);
        $this->assertTrue($progress->isValidated());
    }
}