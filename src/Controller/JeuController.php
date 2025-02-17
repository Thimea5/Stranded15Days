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
                    'decouverte' => $utilisateurInfo->isDecouverte(),
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
        foreach ($informationUtilisateur as $i => $info) {
            if ($informationUtilisateur[$i]->isDecouverte()) {
                $nombreInformations = $i + 1;
                break;
            }
        }
    
        // Logique pour les actions
        if ($data['type'] == 'manger') {
            $existingUser->setFaim($existingUser->getFaim() + 80);
        } elseif ($data['type'] == 'boire') {
            $existingUser->setSoif($existingUser->getSoif() + 80);
        } elseif ($data['type'] == 'reposer') {
            $existingUser->setSante($existingUser->getSante() + 80);
        } elseif ($data['type'] == 'rechercher') {
            // Récupérer l'ID actuel et l'incrémenter de 1
            
            // Chercher l'information avec l'ID incrémenté
            $information = $em->getRepository(Information::class)->findOneBy(['id' => $existingUser->getLastIndice() + 1]);
        
            if ($information) {
                $utilisateurInformation = new UtilisateurInformation();
                $utilisateurInformation->setUtilisateur($existingUser);
                $utilisateurInformation->setInformation($information);
                $utilisateurInformation->setDecouverte(true);
                $existingUser->setLastIndice($existingUser->getLastIndice() + 1);
                $existingUser->addUtilisateurInformation($utilisateurInformation);
                $em->persist($utilisateurInformation);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'Information non trouvée.'], 404);
            }
        }

    
        $existingUser->setNiveau($existingUser->getNiveau() + 1);
        $existingUser->setFaim($existingUser->getFaim() - 20);
        $existingUser->setSoif($existingUser->getSoif() - 20);
        $existingUser->setSante($existingUser->getSante() - 20);
    
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

    #[Route('/jeu/reset', name: 'jeu_reset', methods: ['POST'])]
    public function resetUtilisateur(SessionInterface $session, EntityManagerInterface $em): JsonResponse
    {
        $utilisateur = $session->get('utilisateur');

        if (!$utilisateur) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé.'], 404);
        }

        // Vérifier si l'utilisateur existe en base de données
        $existingUser = $em->getRepository(Utilisateur::class)->findOneBy(['id' => $utilisateur->getId()]);
        if (!$existingUser) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé en base de données.'], 404);
        }

        // Réinitialisation des valeurs de base
        $existingUser->setFaim(50);
        $existingUser->setSoif(50);
        $existingUser->setSante(100);
        $existingUser->setNiveau(1);
        $existingUser->setLastIndice(1);

        // Récupérer toutes les informations liées à l'utilisateur
        $t = $em->getRepository(UtilisateurInformation::class)->findBy(['utilisateur' => $existingUser]);

        $decouvertes = [];
        foreach ($t as $utilisateurInfo) {
            // On vérifie si l'information associée a bien l'ID 1
            if ($utilisateurInfo->getInformation()->getId() !== 1) {
                $utilisateurInfo->setDecouverte(false);
            }
            $decouvertes[$utilisateurInfo->getInformation()->getId()] = $utilisateurInfo->isDecouverte();
        $em->persist($utilisateurInfo);
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
            'jour' => $existingUser->getNiveau(),
            'decouvertes' => $decouvertes
        ]);
    }


    
}
