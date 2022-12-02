<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(InstrumentRepository $instrumentRepository): Response
    {
        $instrument = $instrumentRepository->findAll();
        dump($instrument);
        return $this->render('default/homepage.html.twig');
    }
}
