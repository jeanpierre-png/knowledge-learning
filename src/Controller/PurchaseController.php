<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Purchase;
use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\StripeService;


final class PurchaseController extends AbstractController
{

    #[Route('/stripe/course/{id}', name: 'app_stripe_course')]
    public function stripeCourse(Course $course, StripeService $stripeService): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez étre connecté pour acheter un cursus.');

            return $this->redirectToRoute('app_login');
        }

        if (!$user->isVerified()) {
            $this->addflash( 'warning', 'Vous devez activer votre compte avant de pouvoir effectuer un achat.');

            return $this->redirectToRoute('app_home');
        }

        $session = $stripeService->createCourseCheckoutSession($course);

        return $this->redirect($session->url);

    }

    #[Route('/stripe/lesson/{id}', name: 'app_stripe_lesson')]
    public function stripeLesson(Lesson $lesson, StripeService $stripeService ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez étre connecté pour acheter un cursus.');

            return $this->redirectToRoute('app_login');
        }

        if (!$user->isVerified()) {
            $this->addflash( 'warning', 'Vous devez activer votre compte avant de pouvoir effectuer un achat.');

            return $this->redirectToRoute('app_home');
        }

        $session = $stripeService->createLessonCheckoutSession($lesson);

        return $this->redirect($session->url);

    }

    #[Route('/purchase/course/{id}', name: 'app_purchase_course')]
    public function purchaseCourse(Course $course, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {

            return $this->redirectToRoute('app_login');
        }

        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setCourse($course);
        $purchase->setLesson(null);
        $purchase->setPrice($course->getPrice());
        $purchase->setStatus('PAID');
        $purchase->setPurchasedAt(new \DateTimeImmutable());

        $entityManager->persist($purchase);
        $entityManager->flush();

        $this->addFlash('success', 'Cursus acheté avec succès.');


        return $this->redirectToRoute('app_course', [ 'id' => $course->getId(), ]);
    }


    #[Route('/purchase/lesson/{id}', name: 'app_purchase_lesson')]
    public function purchaseLesson(Lesson $lesson, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {

            return $this->redirectToRoute('app_login');
        }

        $purchase = new Purchase();
        $purchase->setUser($user);
        $purchase->setCourse(null);
        $purchase->setLesson($lesson);
        $purchase->setPrice($lesson->getPrice());
        $purchase->setStatus('PAID');
        $purchase->setPurchasedAt(new \DateTimeImmutable());

        $entityManager->persist($purchase);
        $entityManager->flush();

        $this->addFlash('success', 'Leçon achetée avec succès.');


        return $this->redirectToRoute('app_lesson', [ 'id' => $lesson->getId(), ]);
    }

}




    
