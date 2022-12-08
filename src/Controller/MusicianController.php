<?php

namespace App\Controller;

use App\Entity\Musician;
use App\Form\PubType;
use App\Repository\MusicianRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicianController extends AbstractController
{
    #[Route('/musician', name: 'musician_list')]
    public function list(MusicianRepository $musicianRepository): Response
    {

        return $this->render('musician/index.html.twig', [
            'musicians' => $musicianRepository->findAll(),
        ]);
    }

    #[Route('/musician/{id}', name: 'musician_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id,MusicianRepository $musicianRepository): Response
    {
        $musician = $musicianRepository->find($id);
        //Si le musicien n'existe pas en base de données on retourne une erreur 404
        if ($musician === null){
            return $this->createNotFoundException();
        }
        return $this->render("musician/detail.html.twig", ['musician' => $musician]);
    }

    #[Route('/{id}/edit', name: 'app_pub_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function edit(Request $request, Musician $musician, MusicianRepository $musicianRepository): Response
    {
        $form = $this->createForm(PubType::class, $musician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicianRepository->save($musician, true);

            return $this->redirectToRoute('musician_detail', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pub/edit.html.twig', [
            'musician' => $musician,
            'form' => $form,
        ]);
    }
}
