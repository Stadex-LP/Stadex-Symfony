<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\OrganisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrganisateurRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['organisateur:read']])]
#[GetCollection(normalizationContext: ['groups' => ['organisateurs:read']])]
#[Post(
    normalizationContext: ['groups' => ['organisateur:read']],
    denormalizationContext: ['groups' => ['organisateur:write']]
)]
class Organisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['organisateur:read','organisateurs:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['organisateur:read','organisateurs:read','manifestation:read', 'organisateur:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['organisateur:read','organisateurs:read','manifestation:read', 'organisateur:write'])]
    private ?string $serviceDemandeur = null;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Manifestation::class)]
    private Collection $manifestations;

    public function __construct()
    {
        $this->manifestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getServiceDemandeur(): ?string
    {
        return $this->serviceDemandeur;
    }

    public function setServiceDemandeur(string $serviceDemandeur): self
    {
        $this->serviceDemandeur = $serviceDemandeur;

        return $this;
    }

    /**
     * @return Collection<int, Manifestation>
     */
    public function getManifestations(): Collection
    {
        return $this->manifestations;
    }

    public function addManifestation(Manifestation $manifestation): self
    {
        if (!$this->manifestations->contains($manifestation)) {
            $this->manifestations->add($manifestation);
            $manifestation->setOrganisateur($this);
        }

        return $this;
    }

    public function removeManifestation(Manifestation $manifestation): self
    {
        if ($this->manifestations->removeElement($manifestation)) {
            // set the owning side to null (unless already changed)
            if ($manifestation->getOrganisateur() === $this) {
                $manifestation->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNom() . " - " . $this->getServiceDemandeur();
    }
}
