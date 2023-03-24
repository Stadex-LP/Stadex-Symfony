<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationMainOeuvreRepository;
use App\State\ManifestationMainOeuvreProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationMainOeuvreRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestationMainOeuvre:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestationMainOeuvres:read']])]
#[Post(
    uriTemplate: '/manifestations/{id}/main_oeuvres',
    uriVariables: [
        'id' => new Link(
            toProperty: 'manifestation',
            fromClass: Manifestation::class,
        )
    ],
    normalizationContext: ['groups' => ['manifestationMainOeuvre:read']],
    denormalizationContext: ['groups' => ['manifestationMainOeuvre:write']],
    read: false,
    processor: ManifestationMainOeuvreProcessor::class
)]
class ManifestationMainOeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestationMainOeuvre:read','manifestationMainOeuvres:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['manifestationMainOeuvre:read','manifestationMainOeuvres:read', 'manifestationMainOeuvre:write','manifestation:read'])]
    private ?int $heure = null;

    #[ORM\Column]
    #[Groups(['manifestationMainOeuvre:read','manifestationMainOeuvres:read','manifestation:read'])]
    private ?float $prixHoraireFact = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationMainOeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationMainOeuvre:read','manifestationMainOeuvres:read'])]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationMainOeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationMainOeuvre:read','manifestationMainOeuvres:read', 'manifestationMainOeuvre:write','manifestation:read'])]
    private ?MainOeuvre $mainOeuvre = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getManifestation(): ?Manifestation
    {
        return $this->manifestation;
    }

    public function setManifestation(?Manifestation $manifestation): self
    {
        $this->manifestation = $manifestation;

        return $this;
    }

    public function getMainOeuvre(): ?MainOeuvre
    {
        return $this->mainOeuvre;
    }

    public function setMainOeuvre(?MainOeuvre $mainOeuvre): self
    {
        $this->mainOeuvre = $mainOeuvre;

        return $this;
    }

    public function getPrixTotalHTMainOeuvre():float
    {
        return $this->heure * $this->prixHoraireFact;
    }

    public function getPrixTotalTTCMainOeuvre():float
    {
        return $this->getPrixTotalHTMainOeuvre() * 1.2;
    }
}
