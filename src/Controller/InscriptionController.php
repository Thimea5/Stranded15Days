<?php

namespace App\Controller;

use App\Entity\Information;
use App\Entity\UtilisateurInformation;
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

        // $startInfo = new Information();
        // $startInfo->setTitre('Début de l\'aventure');
        // $startInfo->setDescription('Ca fait plusieurs mois que tu es bloqué dans ton bunker. Dehors c\'est l\'apocalypse et tu n\'asplus de ressources.
        //                             Un mystérieux personnage vous a promis de venir vous chercher pour vous sauver dans 15 jours. A condition que tu lui donnes le code.
        //                             Tu dois donc survivre pendant 15 jours en gérant ta faim, ta soif et ta santé et tout faire pour trouver ce "code". Bonne chance !');
        
        $utilisateur = new Utilisateur();
        $utilisateur->setPseudo($data['pseudo']);
        $utilisateur->setMail($data['email']);
        $utilisateur->setMdp(password_hash($data['password'], PASSWORD_BCRYPT));
        $utilisateur->setNiveau(1);
        $utilisateur->setFaim(50);
        $utilisateur->setSoif(50);
        $utilisateur->setSante(100);

        $allInfo = $em->getRepository(Information::class)->findAll();

        foreach ($allInfo as $info) {
            $informationUtilisateur = new UtilisateurInformation();
            $informationUtilisateur->setInformation($startInfo);
            if ($info->getId() == 1) {
                $informationUtilisateur->setDecouverte(true);
            }
            else {
                $informationUtilisateur->setDecouverte(false);
            }
        }

        $informationUtilisateur->setUtilisateur($utilisateur);
        $utilisateur->addUtilisateurInformation($informationUtilisateur);

        $em->persist($informationUtilisateur);
        $em->persist($utilisateur);
        $em->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], JsonResponse::HTTP_CREATED);
    }
}
