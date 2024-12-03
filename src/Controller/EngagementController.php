<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EngagementController extends AbstractController
{
    #[Route('/engagement', name: 'app_engagement')]
    public function index(): Response
    {
        return $this->render('engagement/index.html.twig', [
            'controller_name' => 'EngagementController',
        ]);
    }
}
