<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ManifestationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManifestationRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['manifestation:read']])]
#[GetCollection(normalizationContext: ['groups' => ['manifestations:read']])]
#[Post(
    normalizationContext: ['groups' => ['manifestation:read']],
    denormalizationContext: ['groups' => ['manifestation:write']]
)]
#[Patch(
    normalizationContext: ['groups' => ['manifestation:read']],
    denormalizationContext: ['groups' => ['manifestation:write']]
)]
#[Delete]
class Manifestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['manifestation:read', 'manifestations:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['manifestation:read', 'manifestations:read', 'manifestation:write'])]
    private ?string $denomination = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestations:read', 'manifestation:write'])]
    private ?DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['manifestation:read', 'manifestations:read', 'manifestation:write'])]
    private ?DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    #[Groups(['manifestation:read', 'manifestations:read', 'manifestation:write'])]
    private ?string $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'manifestations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['manifestation:read', 'manifestation:write'])]
    private ?Organisateur $organisateur = null;

    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: ManifestationMateriel::class, cascade: ['persist', 'remove'])]
    #[Groups(['manifestation:read'])]
    private Collection $manifestationMateriels;

    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: ManifestationTransport::class, cascade: ['persist', 'remove'])]
    #[Groups(['manifestation:read'])]
    private Collection $manifestationTransports;

    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: ManifestationMainOeuvre::class, cascade: ['persist', 'remove'])]
    #[Groups(['manifestation:read'])]
    private Collection $manifestationMainOeuvres;

    #[ORM\OneToMany(mappedBy: 'manifestation', targetEntity: ManifestationEquipementSportif::class, cascade: ['persist', 'remove'])]
    #[Groups(['manifestation:read'])]
    private Collection $manifestationEquipementSportifs;

    public function __construct()
    {
        $this->manifestationMateriels = new ArrayCollection();
        $this->manifestationTransports = new ArrayCollection();
        $this->manifestationMainOeuvres = new ArrayCollection();
        $this->manifestationEquipementSportifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getOrganisateur(): ?Organisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Organisateur $organisateur): self
    {
        $this->organisateur = $organisateur;

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
            $manifestationMateriel->setManifestation($this);
        }

        return $this;
    }

    public function removeManifestationMateriel(ManifestationMateriel $manifestationMateriel): self
    {
        if ($this->manifestationMateriels->removeElement($manifestationMateriel)) {
            // set the owning side to null (unless already changed)
            if ($manifestationMateriel->getManifestation() === $this) {
                $manifestationMateriel->setManifestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ManifestationTransport>
     */
    public function getManifestationTransports(): Collection
    {
        return $this->manifestationTransports;
    }

    public function addManifestationTransport(ManifestationTransport $manifestationTransport): self
    {
        if (!$this->manifestationTransports->contains($manifestationTransport)) {
            $this->manifestationTransports->add($manifestationTransport);
            $manifestationTransport->setManifestation($this);
        }

        return $this;
    }

    public function removeManifestationTransport(ManifestationTransport $manifestationTransport): self
    {
        if ($this->manifestationTransports->removeElement($manifestationTransport)) {
            // set the owning side to null (unless already changed)
            if ($manifestationTransport->getManifestation() === $this) {
                $manifestationTransport->setManifestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ManifestationMainOeuvre>
     */
    public function getManifestationMainOeuvres(): Collection
    {
        return $this->manifestationMainOeuvres;
    }

    public function addManifestationMainOeuvre(ManifestationMainOeuvre $manifestationMainOeuvre): self
    {
        if (!$this->manifestationMainOeuvres->contains($manifestationMainOeuvre)) {
            $this->manifestationMainOeuvres->add($manifestationMainOeuvre);
            $manifestationMainOeuvre->setManifestation($this);
        }

        return $this;
    }

    public function removeManifestationMainOeuvre(ManifestationMainOeuvre $manifestationMainOeuvre): self
    {
        if ($this->manifestationMainOeuvres->removeElement($manifestationMainOeuvre)) {
            // set the owning side to null (unless already changed)
            if ($manifestationMainOeuvre->getManifestation() === $this) {
                $manifestationMainOeuvre->setManifestation(null);
            }
        }

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
            $manifestationEquipementSportif->setManifestation($this);
        }

        return $this;
    }

    public function removeManifestationEquipementSportif(ManifestationEquipementSportif $manifestationEquipementSportif): self
    {
        if ($this->manifestationEquipementSportifs->removeElement($manifestationEquipementSportif)) {
            // set the owning side to null (unless already changed)
            if ($manifestationEquipementSportif->getManifestation() === $this) {
                $manifestationEquipementSportif->setManifestation(null);
            }
        }

        return $this;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalHT(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMateriels as $manifestationMateriel) {
            $prixTotal += $manifestationMateriel->getPrixTotalHTMateriel();
        }
        foreach ($this->manifestationTransports as $manifestationTransport) {
            $prixTotal += $manifestationTransport->getPrixTotalHTTransport();
        }
        foreach ($this->manifestationMainOeuvres as $manifestationMainOeuvre) {
            $prixTotal += $manifestationMainOeuvre->getPrixTotalHTMainOeuvre();
        }
       foreach ($this->manifestationEquipementSportifs as $manifestationEquipementSportif) {
           $prixTotal += $manifestationEquipementSportif->getPrixTotalHTEquipementSportif();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalTTC(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMateriels as $manifestationMateriel) {
            $prixTotal += $manifestationMateriel->getPrixTotalTTCMateriel();
        }
        foreach ($this->manifestationTransports as $manifestationTransport) {
            $prixTotal += $manifestationTransport->getPrixTotalTTCTransport();
        }
        foreach ($this->manifestationMainOeuvres as $manifestationMainOeuvre) {
            $prixTotal += $manifestationMainOeuvre->getPrixTotalTTCMainOeuvre();
        }
        foreach ($this->manifestationEquipementSportifs as $manifestationEquipementSportif) {
            $prixTotal += $manifestationEquipementSportif->getPrixTotalTTCEquipementSportif();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalHTMateriel(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMateriels as $manifestationMateriel) {
            $prixTotal += $manifestationMateriel->getPrixTotalHTMateriel();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalHTTransport(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationTransports as $manifestationTransport) {
            $prixTotal += $manifestationTransport->getPrixTotalHTTransport();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalHTMainOeuvre(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMainOeuvres as $manifestationMainOeuvre) {
            $prixTotal += $manifestationMainOeuvre->getPrixTotalHTMainOeuvre();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalHTEquipementSportif(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationEquipementSportifs as $manifestationEquipementSportif) {
            $prixTotal += $manifestationEquipementSportif->getPrixTotalHTEquipementSportif();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalTTCMateriel(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMateriels as $manifestationMateriel) {
            $prixTotal += $manifestationMateriel->getPrixTotalTTCMateriel();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalTTCTransport(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationTransports as $manifestationTransport) {
            $prixTotal += $manifestationTransport->getPrixTotalTTCTransport();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalTTCMainOeuvre(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationMainOeuvres as $manifestationMainOeuvre) {
            $prixTotal += $manifestationMainOeuvre->getPrixTotalTTCMainOeuvre();
        }
        return $prixTotal;
    }

    #[Groups(['manifestation:read'])]
    public function getPrixTotalTTCEquipementSportif(): float
    {
        $prixTotal = 0;
        foreach ($this->manifestationEquipementSportifs as $manifestationEquipementSportif) {
            $prixTotal += $manifestationEquipementSportif->getPrixTotalTTCEquipementSportif();
        }
        return $prixTotal;
    }

    public function __toString(): string
    {
        return $this->denomination;
    }


}
