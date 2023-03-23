<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ManifestationEquipementSportifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManifestationEquipementSportifRepository::class)]
#[ApiResource]
class ManifestationEquipementSportif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationEquipementSportifs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationEquipementSportifs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EquipementSportif $equipementSportif = null;

    #[ORM\Column]
    private ?int $heure = null;

    #[ORM\Column]
    private ?float $prixHoraireFact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManifestation(): ?Manifestation
    {
        return $this->manifestation;
    }

    public function setManifestation(?Manifestation $manifestation): self
    {
        $this->manifestation = $manifestation;

        return $this;
    }

    public function getEquipementSportif(): ?EquipementSportif
    {
        return $this->equipementSportif;
    }

    public function setEquipementSportif(?EquipementSportif $equipementSportif): self
    {
        $this->equipementSportif = $equipementSportif;

        return $this;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getPrixHoraireFact(): ?float
    {
        return $this->prixHoraireFact;
    }

    public function setPrixHoraireFact(float $prixHoraireFact): self
    {
        $this->prixHoraireFact = $prixHoraireFact;

        return $this;
    }
}
