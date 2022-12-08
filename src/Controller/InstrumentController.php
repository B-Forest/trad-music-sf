<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Repository\InstrumentRepository;


use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends AbstractController
{
    #[Route('/instrument/new', name: 'instrument_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        //créer un nouvel instrument
        $instrument = new Instrument();

        //créer un formulaire pour avoir un nouvel insrument
        $form = $this->createForm(InstrumentType::class, $instrument);

        //On récupere les données du formulaire pour les mettre dans l'entité ($instrument)
        $form->handleRequest($request);

        //On vérifie si les données du formaulaire sont valides
        if ($form->isSubmitted() && $form->isValid() ){

            $entityManager = $doctrine->getManager();

            //Enregistrer les données en base données
             $entityManager->persist($instrument);
             $entityManager->flush();
            //Rediriger l'internaute vers la page d'acceuil
            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('instrument/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instrument', name: 'instrument_list')]
    public function list(InstrumentRepository $instrumentRepository): Response
    {
        return $this->render('instrument/index.html.twig', [
            'instruments' => $instrumentRepository->findAll(),
        ]);
    }

    #[Route('/instrument/{id}', name: 'instrument_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id,InstrumentRepository $instrumentRepository): Response
    {
        $instrument = $instrumentRepository->find($id);
        //Si le musicien n'existe pas en base de données on retourne une erreur 404
        if ($instrument === null){
            return $this->createNotFoundException();
        }
        return $this->render("instrument/detail.html.twig", ['instrument' => $instrument]);
    }

    // afficher la liste des des instruments
    //Cette methode sera appelé en Twig avec render(controller())
    public function listInstruments(InstrumentRepository $instrumentRepository): Response
    {
        $instruments = $instrumentRepository->findBy([], ['name' => 'ASC']);

        return $this->render('instrument/_list.html.twig', [
            'instruments' => $instruments
        ]);
    }
}
