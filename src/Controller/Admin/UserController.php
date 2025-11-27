<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
// Protège toutes les méthodes du controller
#[IsGranted('ROLE_SUPER_ADMIN')]
final class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user')]
    // Protège méthode par méthode
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function viewUsers(): Response
    {
        // Logique pour récupérer la totalité des users
        return $this->render('user/viewusers.html.twig', [

        ]);
    }
}
