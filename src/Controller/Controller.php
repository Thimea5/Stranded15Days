<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('utilisateur')) {
            return $this->redirectToRoute('accueil'); // Redirection vers l'accueil si pas connecté
        }

        return $this->redirectToRoute('jeu'); 
    }
}
