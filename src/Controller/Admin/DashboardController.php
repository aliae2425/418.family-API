<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use App\Entity\Brands;
use App\Entity\Business;
use App\Entity\Cart;
use App\Entity\Family;
use App\Entity\FamilyCategory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private EntityManagerInterface $entityManager
    ){}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/container.html.twig', [
            'user_count' => 100,
            'family_count' => 100,
            'brand_count' => 100,
            'cart_count' => 100,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('418.Family Admin');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            // ->addCssFile('style/admin.css')
            ->addHtmlContentToHead('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Markazi+Text:wght@450" />');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Historique panier', 'fas fa-shopping-cart', Cart::class);
        yield MenuItem::section('Gestion des familles');
        yield MenuItem::linkToCrud('Famille', 'fas fa-cube', Family::class);
        yield MenuItem::linkToCrud('Arboresence', 'fas fa-list', FamilyCategory::class);
        yield MenuItem::section('Gestion des fourniseurs');
        yield MenuItem::linkToCrud('Fourniseurs', 'fas fa-tags', Brands::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-object-ungroup', BrandCategory::class);
    }
}
