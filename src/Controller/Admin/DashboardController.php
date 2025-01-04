<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use App\Entity\Brands;
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
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(BrandsCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/dashboard/container.html.twig', [
            'user_chart' => $chart,
        ]);
    }

    public function UserCount(): int
    {
        return $this->entityManager->getRepository(User::class)->count([]);
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('418.Family Admin');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
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
