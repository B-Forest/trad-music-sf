<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends AbstractController
{
    #[Route('/instrument/new', name: 'instrument_new')]
    public function new(): Response
    {
        //créer un nouvel instrument
        $instrument = new Instrument();

        //créer un formulaire pour avoir un nouvel insrument
        $form = $this->createForm(InstrumentType::class, $instrument);

        return $this->renderForm('instrument/new.html.twig', [
            'form' => $form,
        ]);
    }
}
