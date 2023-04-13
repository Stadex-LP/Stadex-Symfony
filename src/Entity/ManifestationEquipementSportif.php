<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationEquipementSportifRepository;
use App\State\ManifestationEquipementSportifProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationEquipementSportifRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestationEquipementSportif:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestationEquipementSportifs:read']])]
#[Post(
    uriTemplate: '/manifestations/{id}/equipement_sportifs',
    uriVariables: [
        'id' => new Link(
            toProperty: 'manifestation',
            fromClass: Manifestation::class,
        )
    ],
    normalizationContext: ['groups' => ['manifestationEquipementSportif:read']],
    denormalizationContext: ['groups' => ['manifestationEquipementSportif:write']],
    read: false,
    processor: ManifestationEquipementSportifProcessor::class
)]
#[Delete]
class ManifestationEquipementSportif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestationEquipementSportif:read', 'manifestationEquipementSportifs:read', 'manifestation:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationEquipementSportifs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationEquipementSportif:read', 'manifestationEquipementSportifs:read'])]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationEquipementSportifs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationEquipementSportif:read', 'manifestationEquipementSportifs:read', 'manifestation:read', 'manifestationEquipementSportif:write'])]
    private ?EquipementSportif $equipementSportif = null;

    #[ORM\Column]
    #[Groups(['manifestationEquipementSportif:read', 'manifestationEquipementSportifs:read', 'manifestation:read', 'manifestationEquipementSportif:write'])]
    private ?int $heure = null;

    #[ORM\Column]
    #[Groups(['manifestationEquipementSportif:read', 'manifestationEquipementSportifs:read', 'manifestation:read'])]
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

    public function getPrixTotalHTEquipementSportif(): float
    {
        return $this->getHeure() * $this->getPrixHoraireFact();
    }

    public function getPrixTotalTTCEquipementSportif(): float
    {
        return $this->getPrixTotalHTEquipementSportif() * 1.2;
    }
}
