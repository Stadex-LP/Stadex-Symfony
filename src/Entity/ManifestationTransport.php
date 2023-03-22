<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ManifestationTransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManifestationTransportRepository::class)]
#[ApiResource]
class ManifestationTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $heure = null;

    #[ORM\Column]
    private ?float $prixHoraireFact = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationTransports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationTransports')]
    #[ORM\JoinColumn(nullable: false)]
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
}
