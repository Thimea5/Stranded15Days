<?php
// src/Entity/Joueur.php
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

    // Informations d'identification
    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    // Statistiques de progression
    #[ORM\Column]
    private ?int $niveau = 1;

    #[ORM\Column]
    private ?int $experience = 0;

    #[ORM\Column]
    private ?int $sante = 100;

    #[ORM\Column]
    private ?int $faim = 100;

    #[ORM\Column]
    private ?int $soif = 100;

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getmail(): ?string
    {
        return $this->mail;
    }

    public function setmail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;
        return $this;
    }

    public function getSante(): ?int
    {
        return $this->sante;
    }

    public function setSante(int $sante): self
    {
        $this->sante = $sante;
        return $this;
    }

    public function getFaim(): ?int
    {
        return $this->faim;
    }

    public function setFaim(int $faim): self
    {
        $this->faim = $faim;
        return $this;
    }

    public function getSoif(): ?int
    {
        return $this->soif;
    }

    public function setSoif(int $soif): self
    {
        $this->soif = $soif;
        return $this;
    }
}
