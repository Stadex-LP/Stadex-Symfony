<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EquipementSportifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementSportifRepository::class)]
#[ApiResource]
class EquipementSportif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prixHoraire = null;

    #[ORM\Column]
    private ?int $codePlanitec = null;

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

    public function getCodePlanitec(): ?int
    {
        return $this->codePlanitec;
    }

    public function setCodePlanitec(int $codePlanitec): self
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
}
