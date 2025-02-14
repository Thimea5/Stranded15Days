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

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\OneToOne(mappedBy: 'idUtilisateur', cascade: ['persist', 'remove'])]
    private ?ProgressionUtilisateur $progressionUtilisateur = null;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;
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

    public function getProgressionUtilisateur(): ?ProgressionUtilisateur
    {
        return $this->progressionUtilisateur;
    }

    public function setProgressionUtilisateur(ProgressionUtilisateur $progressionUtilisateur): static
    {
        if ($progressionUtilisateur->getIdUtilisateur() !== $this) {
            $progressionUtilisateur->setIdUtilisateur($this);
        }

        $this->progressionUtilisateur = $progressionUtilisateur;
        return $this;
    }
}
