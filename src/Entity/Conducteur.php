<?php

namespace App\Entity;

use App\Repository\ConducteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConducteurRepository::class)]
class Conducteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToMany(targetEntity: Vehicule::class, mappedBy: 'relationconducteur')]
    private Collection $relationvehicule;

    public function __construct()
    {
        $this->relationvehicule = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getRelationvehicule(): Collection
    {
        return $this->relationvehicule;
    }

    public function addRelationvehicule(Vehicule $relationvehicule): self
    {
        if (!$this->relationvehicule->contains($relationvehicule)) {
            $this->relationvehicule->add($relationvehicule);
            $relationvehicule->addRelationconducteur($this);
        }

        return $this;
    }

    public function removeRelationvehicule(Vehicule $relationvehicule): self
    {
        if ($this->relationvehicule->removeElement($relationvehicule)) {
            $relationvehicule->removeRelationconducteur($this);
        }

        return $this;
    }
}
