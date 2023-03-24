<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationMaterielRepository;
use App\State\ManifestationMaterielProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationMaterielRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestationMateriel:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestationMateriels:read']])]
#[Post(
    uriTemplate: '/manifestations/{id}/materiels',
    uriVariables: [
        'id' => new Link(
            toProperty: 'manifestation',
            fromClass: Manifestation::class,
        )
    ],
    normalizationContext: ['groups' => ['manifestationMateriel:read']],
    denormalizationContext: ['groups' => ['manifestationMateriel:write']],
    read: false,
    processor: ManifestationMaterielProcessor::class
)]
class ManifestationMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read','manifestation:read', 'manifestationMateriel:write'])]
    private ?int $jour = null;

    #[ORM\Column]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read','manifestation:read', 'manifestationMateriel:write'])]
    private ?int $qte = null;

    #[ORM\Column]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read','manifestation:read'])]
    private ?float $prixUnitaireFact = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read'])]
    private ?Manifestation $manifestation = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read', 'manifestationMateriel:write', 'manifestation:read'])]
    private ?Materiel $materiel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?int
    {
        return $this->jour;
    }

    public function setJour(int $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPrixUnitaireFact(): ?float
    {
        return $this->prixUnitaireFact;
    }

    public function setPrixUnitaireFact(float $prixUnitaireFact): self
    {
        $this->prixUnitaireFact = $prixUnitaireFact;

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

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

    public function getPrixTotalHTMateriel():float
    {
        if($this->materiel->isEstParJour()){
            return $this->qte * $this->prixUnitaireFact * $this->jour;
        }
        return $this->qte * $this->prixUnitaireFact;
    }

    public function getPrixTotalTTCMateriel():float
    {
        return $this->getPrixTotalHTMateriel() * 1.2;
    }
}
