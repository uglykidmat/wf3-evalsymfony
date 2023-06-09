<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\ManyToMany(targetEntity: Conducteur::class, inversedBy: 'relationvehicule')]
    #[ORM\JoinTable(name: "vehicule_conducteur")]
    private Collection $relationconducteur;

    public function __construct()
    {
        $this->relationconducteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * @return Collection<int, Conducteur>
     */
    public function getRelationconducteur(): Collection
    {
        return $this->relationconducteur;
    }

    public function addRelationconducteur(Conducteur $relationconducteur): self
    {
        if (!$this->relationconducteur->contains($relationconducteur)) {
            $this->relationconducteur[] = $relationconducteur;
            $this->relationconducteur->add($relationconducteur);
        }

        return $this;
    }

    public function removeRelationconducteur(Conducteur $relationconducteur): self
    {
        if ($this->relationconducteur->removeElement($relationconducteur)) {
            // Cette ligne permet de supprimer ce véhicule de la liste des véhicules du conducteur passé en argument.
            // Sans cette ligne, lorsque tu supprimes un conducteur d'un véhicule, le conducteur n'est pas informé qu'il a été supprimé de ce véhicule.
            $relationconducteur->removeRelationvehicule($this);
        }
        return $this;
    }

    public function __toString()
    {
        return $this->marque." ".$this->modele." (".$this->immatriculation.")";
    }
}
