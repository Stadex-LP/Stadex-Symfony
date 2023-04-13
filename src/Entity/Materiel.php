<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['materiel:read']])]
#[GetCollection(normalizationContext: ['groups' => ['materiels:read']])]
#[Post(
    normalizationContext: ['groups' => ['materiel:read']],
    denormalizationContext: ['groups' => ['materiel:write']]
)]
#[Patch(
    normalizationContext: ['groups' => ['materiel:read']],
    denormalizationContext: ['groups' => ['materiel:write']]
)]
#[Delete]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['materiel:read','materiels:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['materiel:read','materiels:read','manifestation:read', 'materiel:write'])]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Groups(['materiel:read','materiels:read', 'materiel:write'])]
    private ?float $prixUnitaire = null;

    #[ORM\Column]
    #[Groups(['materiel:read','materiels:read','manifestation:read', 'materiel:write'])]
    private ?bool $estParJour = null;

    #[ORM\OneToMany(mappedBy: 'materiel', targetEntity: ManifestationMateriel::class)]
    private Collection $manifestationMateriels;

    public function __construct()
    {
        $this->manifestationMateriels = new ArrayCollection();
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

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function isEstParJour(): ?bool
    {
        return $this->estParJour;
    }

    public function setEstParJour(bool $estParJour): self
    {
        $this->estParJour = $estParJour;

        return $this;
    }

    /**
     * @return Collection<int, ManifestationMateriel>
     */
    public function getManifestationMateriels(): Collection
    {
        return $this->manifestationMateriels;
    }

    public function addManifestationMateriel(ManifestationMateriel $manifestationMateriel): self
    {
        if (!$this->manifestationMateriels->contains($manifestationMateriel)) {
            $this->manifestationMateriels->add($manifestationMateriel);
            $manifestationMateriel->setMateriel($this);
        }

        return $this;
    }

    public function removeManifestationMateriel(ManifestationMateriel $manifestationMateriel): self
    {
        if ($this->manifestationMateriels->removeElement($manifestationMateriel)) {
            // set the owning side to null (unless already changed)
            if ($manifestationMateriel->getMateriel() === $this) {
                $manifestationMateriel->setMateriel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}
