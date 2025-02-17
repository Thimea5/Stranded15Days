<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurInformation;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'jeu')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        // Vérifier si l'utilisateur est en session
        $utilisateur = $session->get('utilisateur');

        if (!$utilisateur) {
            // Récupérer un utilisateur par défaut (par exemple, l'utilisateur avec l'ID 1)
            $utilisateur = $em->getRepository(Utilisateur::class)->find(1);
            if (!$utilisateur) {
                throw new \Exception("Aucun utilisateur trouvé.");
            }
            $session->set('utilisateur', $utilisateur);
        }


            $t = $em->getRepository(UtilisateurInformation::class)->findBy(['utilisateur' => $utilisateur]);

            $informations = [];

            // Parcourir chaque élément de la collection $t pour obtenir les informations associées
            foreach ($t as $utilisateurInfo) {
                $information = $utilisateurInfo->getInformation();
                $informations[] = [
                    'titre' => $information->getTitre(),
                    'description' => $information->getDescription(),
                ];
            }
            // Affichage du tableau de bord du jeu
            return $this->render('jeu/index.html.twig', [
                'utilisateur' => $utilisateur,
                'informationUtilisateur' => $informations
            ]);
    }


    #[Route('/jeu/action', name: 'jeu_action', methods: ['POST'])]
    public function jeuAction(Request $request, EntityManagerInterface $em, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['type'])) {
            return new JsonResponse(['success' => false, 'message' => 'Type d\'action manquant.'], 400);
        }
    
        $utilisateur = $session->get('utilisateur');
        if (!$utilisateur) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé.'], 404);
        }
    
        // Vérifier si l'utilisateur existe déjà en base de données
        $existingUser = $em->getRepository(Utilisateur::class)->findOneBy(['id' => $utilisateur->getId()]);
        if (!$existingUser) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé en base de données.'], 404);
        }

    
        $informationUtilisateur = $em->getRepository(UtilisateurInformation::class)->findBy(['utilisateur' => $utilisateur]);

        // Compter le nombre d'éléments dans la collection
        $nombreInformations = count($informationUtilisateur);
    
        // Logique pour les actions
        if ($data['type'] == 'manger') {
            $existingUser->setFaim($existingUser->getFaim() + 20);
        } elseif ($data['type'] == 'boire') {
            $existingUser->setSoif($existingUser->getSoif() + 20);
        } elseif ($data['type'] == 'reposer') {
            $existingUser->setSante($existingUser->getSante() + 20);
        } elseif ($data['type'] == 'rechercher'){
            $existingUser->addUtilisateurInformation($em->getRepository(Information::class)->findOneBy(['id' => $nombreInformations]));
        }
        else {
            return new JsonResponse(['success' => false, 'message' => 'Action non reconnue.'], 400);
        }
    
        $existingUser->setNiveau($existingUser->getNiveau() + 1);
    
        // Persister les changements
        $em->persist($existingUser);
        $em->flush();
    
        return new JsonResponse([
            'success' => true,
            'jour' => $existingUser->getNiveau(),
            'faim' => $existingUser->getFaim(),
            'soif' => $existingUser->getSoif(),
            'sante' => $existingUser->getSante(),
            'informationsUtilisateur' => $existingUser->getUtilisateurInformation()
        ]);
    }

    public function getEvenementJSON() {
        // Chemin vers le fichier JSON
        $jsonFile = '';

        // Vérifier que le fichier existe
        if (!file_exists($jsonFile)) {
            die("Le fichier JSON n'existe pas.");
        }

        // Lire le contenu du fichier JSON
        $jsonContent = file_get_contents($jsonFile);

        // Décoder le JSON en tableau associatif (ajouter true pour avoir un tableau)
        $data = json_decode($jsonContent, true);

        // Vérifier s'il y a eu une erreur lors du décodage
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Erreur lors du décodage JSON : " . json_last_error_msg());
        }
    }

    #[Route('/jeu/reset', name: 'jeu_reset', methods: ['POST'])]
    public function resetUtilisateur(SessionInterface $session, EntityManagerInterface $em): JsonResponse
    {
        $utilisateur = $session->get('utilisateur');

        if (!$utilisateur) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé.'], 404);
        }

        // Vérifier si l'utilisateur existe déjà en base de données
        $existingUser = $em->getRepository(Utilisateur::class)->findOneBy(['id' => $utilisateur->getId()]);
        if (!$existingUser) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé en base de données.'], 404);
        }

        // Réinitialisation des valeurs
        $existingUser->setFaim(50);
        $existingUser->setSoif(50);
        $existingUser->setSante(100);
        $existingUser->setNiveau(1);

        $t = $em->getRepository(UtilisateurInformation::class)->findBy(['utilisateur' => $existingUser]);

        // Parcourir chaque élément de la collection $t pour obtenir les informations associées
        foreach ($t as $utilisateurInfo) {
            $utilisateurInfo->setDecouverte(false);
            $em->persist($utilisateurInfo);
        }
        

        // Sauvegarde des changements
        $em->persist($existingUser);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Progression réinitialisée.',
            'faim' => $existingUser->getFaim(),
            'soif' => $existingUser->getSoif(),
            'sante' => $existingUser->getSante(),
            'jour' => $existingUser->getNiveau()
        ]);
    }

    
}
