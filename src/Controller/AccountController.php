<?php

namespace App\Controller;

use App\Repository\PurchaseRepository;
use App\Repository\CertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
    #[Route('/mes-formation', name: 'app_my_courses')]
    public function myCourses(PurchaseRepository $purchaseRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté.');

            return $this->redirectToRoute('app_login');
        }

        $purchases =$purchaseRepository->findBy([ 'user' => $user, ]);

        return $this->render('account/index.html.twig', [
            'purchases' => $purchases,
        ]);
    }
    #[Route('/mes-certifications', name: 'app_my_certifications')]
    public function myCertifications( CertificationRepository $certificationRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté.');

            return $this->redirectToRoute('app_login');
        }

        $certifications = $certificationRepository->findBy([ 'user' => $user, ]);

        return $this->render('account/certifications.html.twig', [ 'certifications' => $certifications, ]);
    }

}
