<?php

namespace App\Entity;

use App\Repository\ProgressionSurvivantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressionSurvivantRepository::class)]
class ProgressionSurvivant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Lien vers l'utilisateur
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'progressionSurvivants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    // Lien vers un survivant spécifique
    #[ORM\ManyToOne(targetEntity: Survivant::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Survivant $survivant = null;

    #[ORM\Column]
    private ?int $faim = null;

    #[ORM\Column]
    private ?int $soif = null;

    #[ORM\Column]
    private ?bool $maladie = null;

    #[ORM\Column]
    private ?bool $exploration = null;

    #[ORM\Column]
    private ?bool $mort = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getSurvivant(): ?Survivant
    {
        return $this->survivant;
    }

    public function setSurvivant(?Survivant $survivant): static
    {
        $this->survivant = $survivant;

        return $this;
    }

    public function getFaim(): ?int
    {
        return $this->faim;
    }

    public function setFaim(int $faim): static
    {
        $this->faim = $faim;

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

    public function isMaladie(): ?bool
    {
        return $this->maladie;
    }

    public function setMaladie(bool $maladie): static
    {
        $this->maladie = $maladie;

        return $this;
    }

    public function isExploration(): ?bool
    {
        return $this->exploration;
    }

    public function setExploration(bool $exploration): static
    {
        $this->exploration = $exploration;

        return $this;
    }

    public function isMort(): ?bool
    {
        return $this->mort;
    }

    public function setMort(bool $mort): static
    {
        $this->mort = $mort;

        return $this;
    }
}
