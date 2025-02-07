<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class ConnexionController extends AbstractController
{
    #[Route('/api/connexion', name: 'connexion', methods: ['POST'])]
    public function connexion(Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) || empty($data['password'])) {
            return new JsonResponse(['message' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // On cherche l'utilisateur par son email
        $utilisateur = $em->getRepository(Utilisateur::class)->findOneBy(['mail' => $data['email']]);

        if (!$utilisateur) {
            return new JsonResponse(['message' => 'Utilisateur inexistant'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérification du mot de passe
        if (!password_verify($data['password'], $utilisateur->getMdp())) {
            return new JsonResponse(['message' => 'Mot de passe incorrect.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Stocker l'utilisateur dans la session
        $session = $request->getSession();
        $session->set('utilisateur', $utilisateur);

        // Retourner une redirection vers une autre page
        return $this->redirectToRoute('jeu'); 
    }
}
