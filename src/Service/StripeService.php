<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\Lesson;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class StripeService
{
    public function __construct(private string $stripeSecretKey, private UrlGeneratorInterface $urlGenerator)
    {
        
    }

    public function createCourseCheckoutSession(Course $course): Session
    {
        Stripe::setApiKey($this->stripeSecretKey);

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $course->getTitle(),
                    ],
                    'unit_amount' => (int) ((float) $course->getPrice() * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'success_url' => $this->urlGenerator->generate('app_purchase_course', ['id' => $course->getId() ],
                UrlGeneratorInterface::ABSOLUTE_URL),

            'cancel_url' => $this->urlGenerator->generate('app_course', ['id' => $course->getId() ],
                UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }

    public function createLessonCheckoutSession(Lesson $lesson): Session
    {
        Stripe::setApiKey($this->stripeSecretKey);

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $lesson->getTitle(),
                    ],
                    'unit_amount' => (int) ((float) $lesson->getPrice() * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',

            'success_url' => $this->urlGenerator->generate('app_purchase_lesson', ['id' => $lesson->getId() ],
                UrlGeneratorInterface::ABSOLUTE_URL),

            'cancel_url' => $this->urlGenerator->generate('app_course', ['id' => $lesson->getCourse()->getId() ],
                UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }
}