<?php

namespace App\Controller;

use App\Entity\ProgressionUtilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Survivant;
use App\Entity\Utilisateur;
use App\Entity\ProgressionInventaire;
use App\Entity\ProgressionSurvivant;
use App\Entity\Objet;

final class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'jeu')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        // Vérifier si l'utilisateur est bien en session
        $utilisateur = $session->get('utilisateur');

        if (!$utilisateur) {
            // Récupérer un utilisateur par défaut, par exemple ID = 1 (à adapter selon ton projet)
            $utilisateur = $em->getRepository(Utilisateur::class)->find(1);

            if (!$utilisateur) {
                throw new \Exception("Aucun utilisateur trouvé.");
            }

            // Ajouter l'utilisateur dans la session
            $session->set('utilisateur', $utilisateur);
        }

        $progressionUtilisateur = $this->getSauvegarde($utilisateur, $em);

        // Récupérer un survivant précis
        $jean = $em->getRepository(Survivant::class)->findOneBy(['id' => 1]);

        return $this->render('jeu/tableau_de_bord.html.twig', [
            'utilisateur' => $utilisateur,
            'jean' => $jean,
            'progressionUtilisateur' => $progressionUtilisateur
        ]);
    }

    public function getSauvegarde(Utilisateur $utilisateur, EntityManagerInterface $em): ProgressionUtilisateur
    {
        // Récupération de la sauvegarde existante
        $progressionUtilisateur = $em->getRepository(ProgressionUtilisateur::class)->findOneBy(['idUtilisateur' => $utilisateur]);
    
        // Si aucune sauvegarde n'existe, on en crée une nouvelle
        if (!$progressionUtilisateur) {
            $progressionUtilisateur = $this->creerSauvegarde($utilisateur, $em);
        }
    
        return $progressionUtilisateur;
    }
    

    public function creerSauvegarde($utilisateur , EntityManagerInterface $em): ProgressionUtilisateur
    {

        $utilisateur = $em->getRepository(Utilisateur::class)->find($utilisateur->getId());
        if (!$utilisateur) {
            throw new \Exception("Utilisateur non trouvé en base de données.");
        }
        // Vérifier si l'utilisateur a déjà une sauvegarde
        $ancienneProgression = $em->getRepository(ProgressionUtilisateur::class)->findOneBy(['idUtilisateur' => $utilisateur]);
        if ($ancienneProgression) {
            return $ancienneProgression; // Retourner la progression existante si elle existe
        }

        // Création de la progression utilisateur
        $progressionUtilisateur = new ProgressionUtilisateur();
        $progressionUtilisateur->setIdUtilisateur($utilisateur);
        $progressionUtilisateur->setJours(0);

        // Récupération du survivant avec l'ID 1
        $survivant = $em->getRepository(Survivant::class)->find(1);
        if (!$survivant) {
            throw new \Exception("Aucun survivant avec l'ID 1 trouvé.");
        }

        // Création de la progression du survivant
        $progressionSurvivant = new ProgressionSurvivant();
        $progressionSurvivant->setSurvivant($survivant);
        $progressionSurvivant->setUtilisateur($utilisateur);
        $progressionSurvivant->setFaim(2);
        $progressionSurvivant->setSoif(2);
        $progressionSurvivant->setMaladie(false);
        $progressionSurvivant->setExploration(false);
        $progressionSurvivant->setMort(false);

        // Création de l'inventaire de départ
        $inventaire = new ProgressionInventaire();
        $inventaire->setUtilisateur($utilisateur);

        // Persist et flush
        $em->persist($progressionUtilisateur);
        $em->persist($progressionSurvivant);
        $em->persist($inventaire);
        $em->flush();

        return $progressionUtilisateur;
    }
}
