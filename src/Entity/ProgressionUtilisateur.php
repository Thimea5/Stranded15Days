<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProgressionUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private ?int $jours = null;

    #[ORM\OneToOne(inversedBy: 'progressionUtilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_utilisateur_id', referencedColumnName: 'id', unique: true)]
    private ?Utilisateur $idUtilisateur = null;

    // Autres propriétés de la classe

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;
        return $this;
    }

    public function getJours(): ?int
    {
        return $this->jours;
    }

    public function setJours(?int $jours): static
    {
        $this->jours = $jours;
        return $this;
    }

    // Autres méthodes...
}
