<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\EquipementSportifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EquipementSportifRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['equipementSportif:read']])]
#[GetCollection(normalizationContext: ['groups' => ['equipementSportifs:read']])]
#[Post(
    normalizationContext: ['groups' => ['equipementSportif:read']],
    denormalizationContext: ['groups' => ['equipementSportif:write']]
)]
class EquipementSportif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['equipementSportif:read','equipementSportifs:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['equipementSportif:read','equipementSportifs:read','manifestation:read','equipementSportif:write'])]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Groups(['equipementSportif:read','equipementSportifs:read','manifestation:read','equipementSportif:write'])]
    private ?float $prixHoraire = null;

    #[ORM\Column]
    #[Groups(['equipementSportif:read','equipementSportifs:read','manifestation:read','equipementSportif:write'])]
    private ?string $codePlanitec = null;

    #[ORM\OneToMany(mappedBy: 'equipementSportif', targetEntity: ManifestationEquipementSportif::class)]
    private Collection $manifestationEquipementSportifs;

    public function __construct()
    {
        $this->manifestationEquipementSportifs = new ArrayCollection();
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

    public function getPrixHoraire(): ?float
    {
        return $this->prixHoraire;
    }

    public function setPrixHoraire(float $prixHoraire): self
    {
        $this->prixHoraire = $prixHoraire;

        return $this;
    }

    public function getCodePlanitec(): ?string
    {
        return $this->codePlanitec;
    }

    public function setCodePlanitec(string $codePlanitec): self
    {
        $this->codePlanitec = $codePlanitec;

        return $this;
    }

    /**
     * @return Collection<int, ManifestationEquipementSportif>
     */
    public function getManifestationEquipementSportifs(): Collection
    {
        return $this->manifestationEquipementSportifs;
    }

    public function addManifestationEquipementSportif(ManifestationEquipementSportif $manifestationEquipementSportif): self
    {
        if (!$this->manifestationEquipementSportifs->contains($manifestationEquipementSportif)) {
            $this->manifestationEquipementSportifs->add($manifestationEquipementSportif);
            $manifestationEquipementSportif->setEquipementSportif($this);
        }

        return $this;
    }

    public function removeManifestationEquipementSportif(ManifestationEquipementSportif $manifestationEquipementSportif): self
    {
        if ($this->manifestationEquipementSportifs->removeElement($manifestationEquipementSportif)) {
            // set the owning side to null (unless already changed)
            if ($manifestationEquipementSportif->getEquipementSportif() === $this) {
                $manifestationEquipementSportif->setEquipementSportif(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }
}
