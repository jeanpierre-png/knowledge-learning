<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PurchaseRepository;

final class CourseController extends AbstractController
{
    #[Route('/course/{id}', name: 'app_course')]
    public function index(Course $course, PurchaseRepository $purchaseRepository ): Response
    {
        $user = $this->getUser();

        $coursePurchased = false;
        $lessonPurchases = [];

        if ($user) {

            $coursePurchased = $purchaseRepository->findOneBy([
                'user' => $user,
                'course' => $course,
            ]) !== null;

            foreach ($course->getLessons() as $lesson) {

                $lessonPurchases[$lesson->getId()] = $purchaseRepository->findOneBy([
                    'user' => $user,
                    'lesson' => $lesson,
                ]) !== null;
            }
        }

        return $this->render('course/index.html.twig', [
            'course' => $course,
            'coursePurchased' => $coursePurchased !== false,
            'lessonPurchases' => $lessonPurchases,
        ]);
    }
}
