<?php

namespace App\Entity;

use App\Repository\PeriodiciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodiciteRepository::class)]
class Periodicite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'periodicite', targetEntity: Indicateur::class)]
    private Collection $indicateurs;

    public function __construct()
    {
        $this->indicateurs = new ArrayCollection();
    }

    public function __toString(): string {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Indicateur>
     */
    public function getIndicateurs(): Collection
    {
        return $this->indicateurs;
    }

    public function addIndicateur(Indicateur $indicateur): self
    {
        if (!$this->indicateurs->contains($indicateur)) {
            $this->indicateurs->add($indicateur);
            $indicateur->setPeriodicite($this);
        }

        return $this;
    }

    public function removeIndicateur(Indicateur $indicateur): self
    {
        if ($this->indicateurs->removeElement($indicateur)) {
            // set the owning side to null (unless already changed)
            if ($indicateur->getPeriodicite() === $this) {
                $indicateur->setPeriodicite(null);
            }
        }

        return $this;
    }
}
