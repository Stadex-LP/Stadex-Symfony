<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationMaterielRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationMaterielRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestationMateriel:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestationMateriels:read']])]
#[Post(
    normalizationContext: ['groups' => ['manifestationMateriel:read']],
    denormalizationContext: ['groups' => ['manifestationMateriel:write']]
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
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read','manifestation:read', 'manifestationMateriel:write'])]
    private ?float $prixUnitaireFact = null;

    #[ORM\ManyToOne(inversedBy: 'manifestationMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestationMateriel:read','manifestationMateriels:read', 'manifestationMateriel:write'])]
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
}
