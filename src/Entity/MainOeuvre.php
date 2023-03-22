<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MainOeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MainOeuvreRepository::class)]
#[ApiResource]
#[Get(normalizationContext: ['groups' => ['mainOeuvre:read']])]
#[GetCollection(normalizationContext: ['groups' => ['mainOeuvres:read']])]
#[Post(
    normalizationContext: ['groups' => ['mainOeuvre:read']],
    denormalizationContext: ['groups' => ['mainOeuvre:write']]
)]
class MainOeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['mainOeuvre:read','mainOeuvres:read','manifestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mainOeuvre:read','mainOeuvres:read', 'mainOeuvre:write','manifestation:read'])]
    private ?string $categorie = null;

    #[ORM\Column]
    #[Groups(['mainOeuvre:read','mainOeuvres:read', 'mainOeuvre:write','manifestation:read'])]
    private ?float $prixHoraire = null;

    #[ORM\OneToMany(mappedBy: 'mainOeuvre', targetEntity: ManifestationMainOeuvre::class)]
    private Collection $manifestationMainOeuvres;

    public function __construct()
    {
        $this->manifestationMainOeuvres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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
            $manifestationMainOeuvre->setMainOeuvre($this);
        }

        return $this;
    }

    public function removeManifestationMainOeuvre(ManifestationMainOeuvre $manifestationMainOeuvre): self
    {
        if ($this->manifestationMainOeuvres->removeElement($manifestationMainOeuvre)) {
            // set the owning side to null (unless already changed)
            if ($manifestationMainOeuvre->getMainOeuvre() === $this) {
                $manifestationMainOeuvre->setMainOeuvre(null);
            }
        }

        return $this;
    }
}
