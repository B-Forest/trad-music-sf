<?php

namespace App\Controller;

use App\Repository\GigRepository;
use App\Repository\InstrumentRepository;
use App\Repository\ManagerRepository;
use App\Repository\MusicianRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(UserRepository $userRepository,MusicianRepository $musiciansRepository, GigRepository $gigRepository): Response
    {
        $users = $userRepository->findAll();
        $musicians = $musiciansRepository->findAll();
        $gigs = $gigRepository->findFutureGig();
        $checkUser = $this->getUser();

        if ($checkUser)
            $currentUser = $checkUser;


        // appel le fichier de template twig avec la methode render
        return $this->render('default/homepage.html.twig',[
            'user' => $users,
            'musicians' => $musicians,
            'gigs' => $gigs,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {

        return $this->render('default/about.html.twig', [
        ]);
    }


}
