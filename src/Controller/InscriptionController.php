<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class InscriptionController extends AbstractController
{
    #[Route('/api/inscription', name: 'inscription', methods: ['POST'])]
    public function inscription(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if(empty($data['pseudo']) || empty($data['email']) || empty($data['password']) ){
            return new JsonResponse(['message' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $utilisateur = new Utilisateur();
        $utilisateur->setPseudo($data['pseudo']);
        $utilisateur->setMail($data['email']);
        $utilisateur->setMdp(password_hash($data['password'], PASSWORD_BCRYPT));

        $em->persist($utilisateur);
        $em->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], JsonResponse::HTTP_CREATED);
    }
}
