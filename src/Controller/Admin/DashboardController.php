<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use App\Controller\Admin\ThemeCrudController;
use App\Controller\Admin\CourseCrudController;
use App\Controller\Admin\LessonCrudController;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\PurchaseCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct( private AdminUrlGenerator $adminUrlGenerator )
    {

    }


    public function index(): Response
    {
        $url = $this->adminUrlGenerator 
            ->unsetAll()
            ->setController(ThemeCrudController::class)
            ->setAction('index')
            ->generateUrl();
            
           

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Knowledge Learning');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord');
        yield MenuItem::section('Catalogue');

        yield MenuItem::linkTo( ThemeCrudController::class, 'Thèmes' )
        ->setAction('index');

        yield MenuItem::linkTo( CourseCrudController::class, 'Cursus' )
        ->setAction('index');

        yield MenuItem::linkTo( LessonCrudController::class, 'Leçons' )
        ->setAction('index');

        yield MenuItem::section('Utilisateurs');

        yield MenuItem::linkTo( UserCrudController::class, 'Utilisateur' )
        ->setAction('index');

        yield MenuItem::section('Achats');

        yield MenuItem::linkTo( PurchaseCrudController::class, 'Achats' )
        ->setAction('index');
    }
}
