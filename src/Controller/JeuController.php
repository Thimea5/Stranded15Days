<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
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

        // Affichage du tableau de bord du jeu
        return $this->render('jeu/index.html.twig', [
            'utilisateur' => $utilisateur,
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

        error_log("Action reçue : " . $data['type']);

        if($data['type'] == 'manger'){
            $utilisateur->setFaim($utilisateur->getFaim() + 20);
        } elseif($data['type'] == 'boire'){
            $utilisateur->setFaim($utilisateur->getSoif() + 20);
        } elseif($data['type'] == 'reposer'){
            $utilisateur->setFaim($utilisateur->getSante() + 20);
        // } elseif($data['type'] == 'rechercher'){
        //     $utilisateur->setExperience($utilisateur->getExperience() + 20);
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Action non reconnue.'], 400);
        }

        $utilisateur->setNiveau($utilisateur->getNiveau() + 1);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'jour' => $utilisateur->getNiveau(),
            'faim' => $utilisateur->getFaim(),
            'soif' => $utilisateur->getSoif(),
            'sante' => $utilisateur->getSante()
        ]);
    }


    
}
