<?php
namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: "utilisateur", targetEntity: ProgressionSurvivant::class, cascade: ["persist", "remove"])]
    private Collection $progressionSurvivants;

    public function __construct()
    {
        $this->progressionSurvivants = new ArrayCollection();
    }

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

    public function getProgressionSurvivants(): Collection
    {
        return $this->progressionSurvivants;
    }

    public function addProgressionSurvivant(ProgressionSurvivant $progressionSurvivant): static
    {
        if (!$this->progressionSurvivants->contains($progressionSurvivant)) {
            $this->progressionSurvivants->add($progressionSurvivant);
            $progressionSurvivant->setUtilisateur($this);
        }

        return $this;
    }

    public function removeProgressionSurvivant(ProgressionSurvivant $progressionSurvivant): static
    {
        if ($this->progressionSurvivants->removeElement($progressionSurvivant)) {
            if ($progressionSurvivant->getUtilisateur() === $this) {
                $progressionSurvivant->setUtilisateur(null);
            }
        }

        return $this;
    }
}
