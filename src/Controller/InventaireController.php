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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


final class InventaireController extends AbstractController
{
    #[Route('/inventaire', name: 'app_inventaire')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        $utilisateur = $session->get('utilisateur');
        $survivants = $this->getAllSurvivants($utilisateur, $em);
        $survivantsProgression = $this->getProgressionsSurvivants($utilisateur, $em);

        return $this->render('inventaire/index.html.twig', [
            'survivantsProgression' => $survivantsProgression,
            'survivants' => $survivants
        ]);
    }

    public function getAllSurvivants(Utilisateur $utilisateur, EntityManagerInterface $em): array
    {
        // Récupère toutes les entrées de ProgressionSurvivant liées à cet utilisateur
        $progressions = $em->getRepository(ProgressionSurvivant::class)
            ->findBy(['utilisateur' => $utilisateur]);

        return array_map(fn($progression) => $progression->getSurvivant(), $progressions);
    }

    public function getProgressionsSurvivants(Utilisateur $utilisateur, EntityManagerInterface $em): array
    {
        // Récupère toutes les entrées de ProgressionSurvivant liées à cet utilisateur
        return $em->getRepository(ProgressionSurvivant::class)
            ->findBy(['utilisateur' => $utilisateur]);
    }

    #[Route('/updateFaim', name: 'update_faim', methods: ['POST'])]
    public function updateFaim(Request $request, EntityManagerInterface $em): JsonResponse
    {
        dump($request->getContent());
        die;


        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if (empty($data['survivantId']) || !isset($data['faim'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données manquantes.'], 400);
        }

        $survivantData = $data['survivant']; // L'objet survivant reçu en JSON
        $faim = $data['faim']; // Incrémentation de la faim

        // Log pour vérifier le contenu de l'objet survivant
        error_log('Données du survivant : ' . json_encode($survivantData));

        // Récupérer l'entité Survivant à partir de l'objet JSON (par exemple, avec l'ID)
        $survivant = $em->getRepository(Survivant::class)->find($survivantData['id']);

        if (!$survivant) {
            error_log('Survivant non trouvé avec l\'ID : ' . $survivantData['id']);
            return new JsonResponse(['success' => false, 'message' => 'Survivant non trouvé.'], 404);
        }

        // Récupérer l'entité ProgressionSurvivant
        $progressionSurvivant = $em->getRepository(ProgressionSurvivant::class)->findOneBy([
            'survivant' => $survivant
        ]);

        if (!$progressionSurvivant) {
            return new JsonResponse(['success' => false, 'message' => 'Progression du survivant non trouvée.'], 404);
        }

        // Mise à jour de la faim
        $progressionSurvivant->setFaim($progressionSurvivant->getFaim() + $faim);

        if ($progressionSurvivant->getFaim() <= 0) {
            $progressionSurvivant->setMort(true);
        }

        // Sauvegarde dans la base de données
        $em->flush();

        return new JsonResponse(['success' => true, 'message' => 'Faim mise à jour avec succès.']);
    }
}
