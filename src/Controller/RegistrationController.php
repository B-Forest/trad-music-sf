<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Entity\Musician;
use App\Form\RegistrationManagerFormType;
use App\Form\RegistrationMusicianFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ): Response
    {
        //Pourquoi avant mes $users rentrait en conflits ?
        $user = new Manager();
        $user->setRoles(['ROLE_MANAGER']);
        $formManager = $this->createForm(RegistrationManagerFormType::class, $user);

        $user2 = new Musician();
        $user2->setRoles(['ROLE_MUSICIAN']);
        $formMusician = $this->createForm(RegistrationMusicianFormType::class, $user2);

        $formManager->handleRequest($request);
        $formMusician->handleRequest($request);

        if ($formMusician->isSubmitted() && $formMusician->isValid()) {
            // encode the plain password
            $user2->setPassword(
                $userPasswordHasher->hashPassword(
                    $user2,
                    $formMusician->get('plainPassword')->getData()
                )
            );
            // Uploader l'image
            $image = $formMusician->get('image')->getData();
            if ($image) {
                $fileName = $fileUploader->upload($image);
                $user2->setImage($fileName);
            }

            $entityManager->persist($user2);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('homepage');


        }
        if ($formManager->isSubmitted() && $formManager->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formManager->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('homepage');
        } ;
        return $this->render('registration/register.html.twig', [
            'registrationFormMusician' => $formMusician->createView(),
            'registrationFormManager' => $formManager->createView()
        ]);
    }


}