<?php

namespace App\Entity;

use App\Repository\EtatUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatUtilisateurRepository::class)]
class EtatUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'etatUtilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoire $histoire = null;

    #[ORM\Column]
    private ?int $satiete = null;

    #[ORM\Column]
    private ?int $soif = null;

    #[ORM\Column]
    private ?int $fatigue = null;

    #[ORM\Column(nullable: true)]
    private ?int $chapitre = null;

    #[ORM\Column(nullable: true)]
    private ?int $etape = null;

    #[ORM\Column(nullable: true)]
    private ?int $dernierChoix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getHistoire(): ?Histoire
    {
        return $this->histoire;
    }

    public function setHistoire(Histoire $histoire): static
    {
        $this->histoire = $histoire;

        return $this;
    }

    public function getSatiete(): ?int
    {
        return $this->satiete;
    }

    public function setSatiete(int $satiete): static
    {
        $this->satiete = $satiete;

        return $this;
    }

    public function getSoif(): ?int
    {
        return $this->soif;
    }

    public function setSoif(int $soif): static
    {
        $this->soif = $soif;

        return $this;
    }

    public function getFatigue(): ?int
    {
        return $this->fatigue;
    }

    public function setFatigue(int $fatigue): static
    {
        $this->fatigue = $fatigue;

        return $this;
    }

    public function getChapitre(): ?int
    {
        return $this->chapitre;
    }

    public function setChapitre(?int $chapitre): static
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    public function getEtape(): ?int
    {
        return $this->etape;
    }

    public function setEtape(?int $etape): static
    {
        $this->etape = $etape;

        return $this;
    }

    public function getDernierChoix(): ?int
    {
        return $this->dernierChoix;
    }

    public function setDernierChoix(?int $dernierChoix): static
    {
        $this->dernierChoix = $dernierChoix;

        return $this;
    }
}
