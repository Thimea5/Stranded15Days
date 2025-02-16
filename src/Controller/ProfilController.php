<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(SessionInterface $session): Response
    {
        //Ajouter sauvegarde avant la déconnexion
        return $this->render('profil/index.html.twig', [
            'utilisateur' => $session->get('utilisateur')
        ]);
    }
}
