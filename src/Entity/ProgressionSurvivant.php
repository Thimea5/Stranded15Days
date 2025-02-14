<?php

namespace App\Entity;

use App\Repository\ProgressionSurvivantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressionSurvivantRepository::class)]
class ProgressionSurvivant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'progressionSurvivants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProgressionUtilisateur $progression_id = null;

    /**
     * @var Collection<int, Survivant>
     */
    #[ORM\ManyToMany(targetEntity: Survivant::class)]
    private Collection $survivant_id;

    #[ORM\Column]
    private ?bool $faim = null;

    #[ORM\Column]
    private ?int $soif = null;

    #[ORM\Column]
    private ?bool $maladie = null;

    #[ORM\Column]
    private ?bool $exploration = null;

    public function __construct()
    {
        $this->survivant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgressionId(): ?ProgressionUtilisateur
    {
        return $this->progression_id;
    }

    public function setProgressionId(?ProgressionUtilisateur $progression_id): static
    {
        $this->progression_id = $progression_id;

        return $this;
    }

    /**
     * @return Collection<int, Survivant>
     */
    public function getSurvivantId(): Collection
    {
        return $this->survivant_id;
    }

    public function addSurvivantId(Survivant $survivantId): static
    {
        if (!$this->survivant_id->contains($survivantId)) {
            $this->survivant_id->add($survivantId);
        }

        return $this;
    }

    public function removeSurvivantId(Survivant $survivantId): static
    {
        $this->survivant_id->removeElement($survivantId);

        return $this;
    }

    public function isFaim(): ?bool
    {
        return $this->faim;
    }

    public function setFaim(bool $faim): static
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
}
