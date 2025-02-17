<?php

namespace App\Entity;

use App\Repository\UtilisateurInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurInformationRepository::class)]
class UtilisateurInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurInformation', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Information $Information = null;

    #[ORM\Column]
    private ?bool $Decouverte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getInformation(): ?Information
    {
        return $this->Information;
    }

    public function setInformation(?Information $Information): static
    {
        $this->Information = $Information;

        return $this;
    }

    public function isDecouverte(): ?bool
    {
        return $this->Decouverte;
    }

    public function setDecouverte(bool $Decouverte): static
    {
        $this->Decouverte = $Decouverte;

        return $this;
    }
}
