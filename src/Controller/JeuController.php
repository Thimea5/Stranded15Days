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

    #[Route('/updateFaim', name: 'update_faim', methods: ['POST'])]
    public function updateFaim(Request $request, EntityManagerInterface $em, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['faim'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données manquantes.'], 400);
        }

        $utilisateur = $session->get('utilisateur');
        if (!$utilisateur) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé.'], 404);
        }

        // Par exemple, augmenter la faim du joueur de la valeur fournie (sans dépasser 100)
        $nouvelleFaim = min($utilisateur->getFaim() + (int)$data['faim'], 100);
        $utilisateur->setFaim($nouvelleFaim);

        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Faim mise à jour avec succès.',
            'faim' => $nouvelleFaim,
        ]);
    }
}
