<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function viewProfile(): Response
    {
        // Récupérer l'utilisateur en cours via getUser()
        return $this->render('profile/viewprofile.html.twig', []);
    }

    #[Route('/editProfile', name: 'app_edit_profile')]
    public function EditProfile(): Response
    {
        // Récupérer Les données du formulaire et les setter dans la DB
        return $this->render('profile/editprofile.html.twig', []);
    }
}
