<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationTransportRepository;
use App\State\ManifestationTransportProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationTransportRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestationTransport:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestationTransports:read']])]
#[Post(
    uriTemplate: '/manifestation/{id}/transports',
    uriVariables: [
        'id' => new Link(
            toProperty: 'manifestation',
            fromClass: Manifestation::class,
        )
    ],
    normalizationContext: ['groups' => ['manifestationTransport:read']],
    denormalizationContext: ['groups' => ['manifestationTransport:write']],
    read: false,
    processor: ManifestationTransportProcessor::class
)]
class ManifestationTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestationTransport:read','manifestationTransports:read', 'manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['manifestationTransport:read','manifestationTransports:read', 'manifestationTransport:write', 'manifestation:read'])]
    private ?int $heure = null;

    #[ORM\Column]
    #[Groups(['manifestationTransport:read','manifestationTransports:read', 'manifestation:read'])]
    private ?float $prixHoraireFact = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationTransports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationTransport:read','manifestationTransports:read'])]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationTransports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationTransport:read','manifestationTransports:read', 'manifestationTransport:write', 'manifestation:read'])]
    private ?Transport $transport = null;

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

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getPrixTotalHTTransport():float
    {
        return $this->prixHoraireFact * $this->heure;

    }

    public function getPrixTotalTTCTransport():float
    {
        return $this->getPrixTotalHTTransport() * 1.2;
    }
}
