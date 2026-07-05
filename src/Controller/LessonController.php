<?php

namespace App\Controller;

use App\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LessonController extends AbstractController
{
    #[Route('/lesson/{id}', name: 'app_lesson')]
    public function index(Lesson $lesson): Response
    {
        return $this->render('lesson/index.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
