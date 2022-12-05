<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GigController extends AbstractController
{
    #[Route('/gig', name: 'gig_list')]
    public function index(): Response
    {
        return $this->render('gig/index.html.twig', [
            'controller_name' => 'GigController',
        ]);
    }
}
