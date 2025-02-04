<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $satiete = null;

    #[ORM\Column(nullable: true)]
    private ?int $soif = null;

    #[ORM\Column(nullable: true)]
    private ?int $fatigue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $effet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSatiete(): ?int
    {
        return $this->satiete;
    }

    public function setSatiete(?int $satiete): static
    {
        $this->satiete = $satiete;

        return $this;
    }

    public function getSoif(): ?int
    {
        return $this->soif;
    }

    public function setSoif(?int $soif): static
    {
        $this->soif = $soif;

        return $this;
    }

    public function getFatigue(): ?int
    {
        return $this->fatigue;
    }

    public function setFatigue(?int $fatigue): static
    {
        $this->fatigue = $fatigue;

        return $this;
    }

    public function getEffet(): ?string
    {
        return $this->effet;
    }

    public function setEffet(?string $effet): static
    {
        $this->effet = $effet;

        return $this;
    }
}
