<?php

namespace App\Entity;

use App\Repository\ProgressionInventaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressionInventaireRepository::class)]
class ProgressionInventaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, progressionUtilisateur>
     */
    #[ORM\OneToMany(targetEntity: progressionUtilisateur::class, mappedBy: 'progressionInventaire')]
    private Collection $progression_id;

    /**
     * @var Collection<int, Objet>
     */
    #[ORM\ManyToMany(targetEntity: Objet::class)]
    private Collection $objet_id;

    public function __construct()
    {
        $this->progression_id = new ArrayCollection();
        $this->objet_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, progressionUtilisateur>
     */
    public function getProgressionId(): Collection
    {
        return $this->progression_id;
    }

    public function addProgressionId(progressionUtilisateur $progressionId): static
    {
        if (!$this->progression_id->contains($progressionId)) {
            $this->progression_id->add($progressionId);
            $progressionId->setProgressionInventaire($this);
        }

        return $this;
    }

    public function removeProgressionId(progressionUtilisateur $progressionId): static
    {
        if ($this->progression_id->removeElement($progressionId)) {
            // set the owning side to null (unless already changed)
            if ($progressionId->getProgressionInventaire() === $this) {
                $progressionId->setProgressionInventaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Objet>
     */
    public function getObjetId(): Collection
    {
        return $this->objet_id;
    }

    public function addObjetId(Objet $objetId): static
    {
        if (!$this->objet_id->contains($objetId)) {
            $this->objet_id->add($objetId);
        }

        return $this;
    }

    public function removeObjetId(Objet $objetId): static
    {
        $this->objet_id->removeElement($objetId);

        return $this;
    }
}
