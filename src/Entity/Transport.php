<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prixHoraire = null;

    #[ORM\OneToMany(mappedBy: 'transport', targetEntity: ManifestationTransport::class)]
    private Collection $manifestationTransports;

    public function __construct()
    {
        $this->manifestationTransports = new ArrayCollection();
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
            $manifestationTransport->setTransport($this);
        }

        return $this;
    }

    public function removeManifestationTransport(ManifestationTransport $manifestationTransport): self
    {
        if ($this->manifestationTransports->removeElement($manifestationTransport)) {
            // set the owning side to null (unless already changed)
            if ($manifestationTransport->getTransport() === $this) {
                $manifestationTransport->setTransport(null);
            }
        }

        return $this;
    }
}
