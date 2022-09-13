<?php

namespace App\Entity;

use App\Repository\IndicateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IndicateurRepository::class)]
class Indicateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'indicateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodicite $periodicite = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    #[ORM\ManyToOne(inversedBy: 'indicateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeIndicateur $type_indicateur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $analyse_interpretation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(?Periodicite $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTypeIndicateur(): ?TypeIndicateur
    {
        return $this->type_indicateur;
    }

    public function setTypeIndicateur(?TypeIndicateur $type_indicateur): self
    {
        $this->type_indicateur = $type_indicateur;

        return $this;
    }

    public function getAnalyseInterpretation(): ?string
    {
        return $this->analyse_interpretation;
    }

    public function setAnalyseInterpretation(string $analyse_interpretation): self
    {
        $this->analyse_interpretation = $analyse_interpretation;

        return $this;
    }
}
