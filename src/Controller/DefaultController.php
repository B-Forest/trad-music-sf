<?php

namespace App\Controller;

use App\Repository\GigRepository;
use App\Repository\InstrumentRepository;
use App\Repository\ManagerRepository;
use App\Repository\MusicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MusicianRepository $musiciansRepository, GigRepository $gigRepository): Response
    {
        $musicians = $musiciansRepository->findAll();
        $gigs = $gigRepository->findAll();

        // appel le fichier de template twig avec la methode render
        return $this->render('default/homepage.html.twig',[
            'musicians' => $musicians,
            'gigs' => $gigs,
        ]);
    }


}
