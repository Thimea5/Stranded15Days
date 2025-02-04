<?php

namespace App\Entity;

use App\Repository\EtapeHistoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeHistoireRepository::class)]
class EtapeHistoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Histoire $histoire = null;

    /**
     * @var Collection<int, Choix>
     */
    #[ORM\OneToMany(targetEntity: Choix::class, mappedBy: 'etapeHistoire')]
    private Collection $choixes;

    public function __construct()
    {
        $this->choixes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHistoire(): ?Histoire
    {
        return $this->histoire;
    }

    public function setHistoire(?Histoire $histoire): static
    {
        $this->histoire = $histoire;

        return $this;
    }

    /**
     * @return Collection<int, Choix>
     */
    public function getChoixes(): Collection
    {
        return $this->choixes;
    }

    public function addChoix(Choix $choix): static
    {
        if (!$this->choixes->contains($choix)) {
            $this->choixes->add($choix);
            $choix->setEtapeHistoire($this);
        }

        return $this;
    }

    public function removeChoix(Choix $choix): static
    {
        if ($this->choixes->removeElement($choix)) {
            // set the owning side to null (unless already changed)
            if ($choix->getEtapeHistoire() === $this) {
                $choix->setEtapeHistoire(null);
            }
        }

        return $this;
    }
}
