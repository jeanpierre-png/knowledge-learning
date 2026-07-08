<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\LessonProgress;
use App\Entity\Certification;
use App\Repository\PurchaseRepository;
use App\Repository\LessonProgressRepository;
use App\Repository\CertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


final class LessonController extends AbstractController
{
    #[Route('/lesson/{id}', name: 'app_lesson')]
    public function index(Lesson $lesson, PurchaseRepository $purchaseRepository): Response
    {

        $user = $this->getUser();

        if (!$user) {

            $this->addFlash('warning', 'Vous devez être connecté.');

            return $this->redirectToRoute('app_login');
        }

        $lessonPurchase = $purchaseRepository->findOneBy([
            'user' => $user,
            'lesson' => $lesson,
        ]);

        $coursePurchase = $purchaseRepository->findOneBy([
            'user' => $user,
            'course' => $lesson->getCourse(),
        ]);

        if (!$lessonPurchase && !$coursePurchase) {

            $this->addFlash('warning', 'Vous devez acheter cette leçon ou son cursus pour y accéder.');

            return $this->redirectToRoute('app_course', [
            'id' => $lesson->getCourse()->getId(),
            ]);

        };

        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/lesson/{id}/validate', name: 'app_lesson_validate')]
    public function validateLesson(Lesson $lesson, LessonProgressRepository $lessonProgressRepository, CertificationRepository $certificationRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {

            $this->addFlash('warning', 'Vous devez être connecté.');

            return $this->redirectToRoute('app_login');
        }

        $existingProgress = $lessonProgressRepository->findOneBy([
            'user' => $user,
            'lesson' => $lesson,
        ]);

        if ($existingProgress) {

            $this->addFlash('warning', 'Cette leçon est déjà validée.');

            return $this->redirectToRoute('app_lesson', [ 'id' => $lesson->getId(), ]);

        }

        $progress = new LessonProgress();
        $progress->setUser($user);
        $progress->setLesson($lesson);
        $progress->setValidated(true);
        $progress->setValidatedAt(new \DateTimeImmutable());

        $entityManager->persist($progress);

        $course = $lesson->getCourse();

        $totalLessons = $course->getLessons()->count();

        $validatedLessons = 0;

        foreach ($course->getLessons() as $courseLesson) {
            $progress = $lessonProgressRepository->findOneBy([
                'user' => $user,
                'lesson' => $courseLesson,
            ]);

            if ($progress || $courseLesson === $lesson) {
                $validatedLessons++;
            }
        }

        $existingCertification = $certificationRepository->findOneBy([
            'user' => $user,
            'course' => $course,
        ]);

        if ($validatedLessons === $totalLessons && !$existingCertification) {

            $certification = new Certification();
            $certification->setUser($user);
            $certification->setCourse($course);
            $certification->setObtainedAt(new \DateTimeImmutable());

            $entityManager->persist($certification);

            $this->addFlash('success', 'Félicitations, vous avez obtenu une certification Knowledge Learning.');

        }
        
        $entityManager->flush();

        $this->addFlash('success', 'Leçon validée avec succès.');
        
        return $this->redirectToRoute('app_lesson', [ 'id' => $lesson->getId(), ]);

    }
}
