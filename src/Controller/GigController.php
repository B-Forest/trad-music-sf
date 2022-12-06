<?php

namespace App\Controller;

use App\Entity\Gig;
use App\Repository\GigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GigController extends AbstractController
{
    #[Route('/gig', name: 'gig_list')]
    public function list(GigRepository $gigRepository): Response
    {
        return $this->render('gig/index.html.twig', [
            'gigs' => $gigRepository->findAll(),
        ]);
    }

    #[Route('/gig/{id}', name: 'gig_detail')]
    public function detail(Gig $gig): Response
    {
        return $this->render('gig/detail.html.twig', ['gig' => $gig]);
    }

}
