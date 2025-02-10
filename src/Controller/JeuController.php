<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Utilisateur;
use App\Entity\Objet;

final class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'jeu')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        $objet = $em->getRepository(Objet::class)->findOneBy(['nom' => "miche_de_pain"]);

        $cheminFichier = $this->getParameter('kernel.project_dir') . '/src/data/scenarios.json'; // Chemin vers fichier JSON
        $contenuJson = file_get_contents($cheminFichier);
        $donnees = json_decode($contenuJson, true); // true pour un tableau associatif

        // Gérer les erreurs si le fichier n'existe pas ou ne contient pas le scénario
        

        $scenarioData = $donnees['scenarios'];

        return $this->render('jeu/tableau_de_bord.html.twig', [
            'utilisateur' => $session->get('utilisateur'),
            'objet' => $objet,
            'scenario' => $scenarioData
        ]);
    }
}
