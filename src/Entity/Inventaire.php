<?php

namespace App\Entity;

use App\Repository\InventaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventaireRepository::class)]
class Inventaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'inventaire', cascade: ['persist', 'remove'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoire $histoire = null;

    /**
     * @var Collection<int, Objet>
     */
    #[ORM\ManyToMany(targetEntity: Objet::class)]
    private Collection $objet;

    public function __construct()
    {
        $this->objet = new ArrayCollection();
    }

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

    public function getHistoire(): ?Histoire
    {
        return $this->histoire;
    }

    public function setHistoire(Histoire $histoire): static
    {
        $this->histoire = $histoire;

        return $this;
    }

    /**
     * @return Collection<int, Objet>
     */
    public function getObjet(): Collection
    {
        return $this->objet;
    }

    public function addObjet(Objet $objet): static
    {
        if (!$this->objet->contains($objet)) {
            $this->objet->add($objet);
        }

        return $this;
    }

    public function removeObjet(Objet $objet): static
    {
        $this->objet->removeElement($objet);

        return $this;
    }
}
