<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Entity\Objet;
use App\Entity\EtatUtilisateur;
use App\Entity\Histoire;

final class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'jeu')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        // Récupérer un objet précis
        $objet = $em->getRepository(Objet::class)->findOneBy(['nom' => "miche_de_pain"]);

        // Charger les données de scénario à partir du fichier JSON
        $cheminFichier = $this->getParameter('kernel.project_dir') . '/src/data/scenarios.json'; // Chemin vers fichier JSON
        $contenuJson = file_get_contents($cheminFichier);
        $donnees = json_decode($contenuJson, true); // true pour un tableau associatif
        $scenarioData = $donnees['scenarios'];
        $etatUtilisateur = $this->getEtatUtilisateur($session, $em);
        $etape = $etatUtilisateur->getEtape();
        $chapitre = $etatUtilisateur->getChapitre();

        return $this->render('jeu/tableau_de_bord.html.twig', [
            'utilisateur' => $session->get('utilisateur'),
            'objet' => $objet,
            'scenario' => $scenarioData,
            'etatUtilisateur' => $etatUtilisateur,
            'sauvegardeChapitre' => $chapitre,
            'sauvegardeEtape' => $etape
        ]);
    }

    public function getEtatUtilisateur(SessionInterface $session, EntityManagerInterface $em): EtatUtilisateur
    {
        $utilisateur = $session->get('utilisateur'); 
        $histoire = $em->getRepository(Histoire::class)->findOneBy(['id' => '1']);

        $donnees = $em->getRepository(EtatUtilisateur::class)->findOneBy(['utilisateur' => $utilisateur, 'histoire' => $histoire]);

        if (!$donnees) {
            $donnees = $this->creerSauvegarde($utilisateur, $histoire , $em); // Créer une nouvelle sauvegarde si elle n'existe pas
        } 


        return $donnees;
    }

    public function creerSauvegarde($utilisateur, $histoire , EntityManagerInterface $em): EtatUtilisateur
    {
        $etatUtilisateur = new EtatUtilisateur();
        $etatUtilisateur->setUtilisateur($utilisateur);
        $etatUtilisateur->setHistoire($histoire);
        $etatUtilisateur->setSatiete(5);
        $etatUtilisateur->setSoif(5);
        $etatUtilisateur->setFatigue(5);
        $etatUtilisateur->setChapitre(1);
        $etatUtilisateur->setEtape(1);

        $em->persist($etatUtilisateur);
        $em->flush();

        return $etatUtilisateur;
    }
}
