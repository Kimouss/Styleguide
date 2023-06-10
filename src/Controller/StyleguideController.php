<?php

namespace App\Controller;

use App\Service\SidebarManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StyleguideController extends AbstractController
{
    #[Route('/', name: 'app_styleguide')]
    public function index(SidebarManager $sidebarManager): Response
    {
        return $this->render('styleguide/index.html.twig', [
            'controller_name' => 'StyleguideController',
            'sidebarData' => $sidebarManager->getSidebarEntries(),
        ]);
    }
}
