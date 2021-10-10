<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

/**
 *  Controller class for the Dashboard UI component
 */
class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;
    /**
     * DashboardController class constructor
     * @param AdminUrlGenerator $adminUrlGenerator
     */
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(BlogPostCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }
}
