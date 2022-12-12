<?php

namespace App\Controller;

use App\Entity\Gig;
use App\Entity\Pub;
use App\Form\NewGigType;
use App\Repository\GigRepository;
use App\Repository\PubRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GigController extends AbstractController
{
    #[Route('/gig', name: 'gig_list', methods: ['GET']) ]
    public function list(GigRepository $gigRepository): Response
    {
        return $this->render('gig/index.html.twig', [
            'gigs' => $gigRepository->findAll(),
            'gigsfuture'=> $gigRepository->findFutureGig(),
            'gigspast' => $gigRepository->findPastGig(),
        ]);
    }

    #[Route('/gig/new', name: 'app_gig_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function new(Request $request, GigRepository $gigRepository): Response
    {
        //créer un nouvel instrument
        $gig = new Gig();

        //créer un formulaire pour avoir un nouvel concert
        $form = $this->createForm(NewGigType::class, $gig);

        //On récupere les données du formulaire pour les mettre dans l'entité ($pub)
        $form->handleRequest($request);

        //On vérifie si les données du formaulaire sont valides
        if ($form->isSubmitted() && $form->isValid() ){

            $gigRepository->save($gig, true);

            return $this->redirectToRoute('gig_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gig/new.html.twig', [
            'newGigType' => $form,
        ]);
    }

    #[Route('/gig/{id}', name: 'gig_detail')]
    public function detail(Gig $gig): Response
    {
        return $this->render('gig/detail.html.twig', ['gig' => $gig]);
    }



}
