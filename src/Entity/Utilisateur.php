<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?EtatUtilisateur $etatUtilisateur = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Inventaire $inventaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getEtatUtilisateur(): ?EtatUtilisateur
    {
        return $this->etatUtilisateur;
    }

    public function setEtatUtilisateur(EtatUtilisateur $etatUtilisateur): static
    {
        // set the owning side of the relation if necessary
        if ($etatUtilisateur->getUtilisateur() !== $this) {
            $etatUtilisateur->setUtilisateur($this);
        }

        $this->etatUtilisateur = $etatUtilisateur;

        return $this;
    }

    public function getInventaire(): ?Inventaire
    {
        return $this->inventaire;
    }

    public function setInventaire(?Inventaire $inventaire): static
    {
        // unset the owning side of the relation if necessary
        if ($inventaire === null && $this->inventaire !== null) {
            $this->inventaire->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($inventaire !== null && $inventaire->getUtilisateur() !== $this) {
            $inventaire->setUtilisateur($this);
        }

        $this->inventaire = $inventaire;

        return $this;
    }
}
