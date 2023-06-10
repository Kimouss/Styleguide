<?php

namespace App\Controller;

use App\Service\SidebarManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TemplateController extends AbstractController
{
    #[Route('/{directory}', name: 'app_template_index', requirements: ['directory' => '.+'])]
    public function index(string $directory, Environment $environment, SidebarManager $sidebarManager): Response
    {
        $templatePath = $directory . '/index.html.twig';
        $templateExists = $environment->getLoader()->exists($templatePath);
        if (!$templateExists) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            $templatePath,
            ['sidebarData' => $sidebarManager->getSidebarEntries()]
        );
    }
}
