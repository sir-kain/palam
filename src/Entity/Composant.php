<?php

namespace App\Entity;

use App\Repository\ComposantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ComposantRepository::class)]
class Composant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'composant', targetEntity: Activite::class)]
    private Collection $activites;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    private ?string $days = null;
    
    #[ORM\Column(nullable: true)]
    private ?int $niveau_achevement = null;

    #[ORM\OneToMany(mappedBy: 'composant', targetEntity: Indicateur::class)]
    private Collection $indicateurs;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->indicateurs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?string
    {
        if ($this->getDateFin() && $this->getDateDebut()) {
            return date_diff($this->getDateFin(),$this->getDateDebut())->days;
        }

        return $this->days;
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
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setComposant($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getComposant() === $this) {
                $activite->setComposant(null);
            }
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getNiveauAchevement(): ?int
    {
        return $this->niveau_achevement;
    }

    public function setNiveauAchevement(?int $niveau_achevement): self
    {
        $this->niveau_achevement = $niveau_achevement;

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
            $indicateur->setComposant($this);
        }

        return $this;
    }

    public function removeIndicateur(Indicateur $indicateur): self
    {
        if ($this->indicateurs->removeElement($indicateur)) {
            // set the owning side to null (unless already changed)
            if ($indicateur->getComposant() === $this) {
                $indicateur->setComposant(null);
            }
        }

        return $this;
    }
}
