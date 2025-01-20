<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 50)]
    private ?string $nomTerrain = null;

    #[ORM\Column]
    private ?int $Capacite = null;

    #[ORM\Column]
    private ?bool $Disponible = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[ORM\ManyToOne(inversedBy: 'Categorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $Categorie = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'Terrain', orphanRemoval: true)]
    private Collection $Terrain;
    /**
     * @var Collection<int, Reservation>
     */


    public function __construct()
    {
        $this->Terrain = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTerrain(): ?string
    {
        return $this->nomTerrain;
    }

    public function setNomTerrain(string $nomTerrain): static
    {
        $this->nomTerrain = $nomTerrain;

        return $this;
    }


public function getCapacite(): ?int
{
    return $this->Capacite;
}

public function setCapacite(int $Capacite): static
{
    $this->Capacite = $Capacite;
    return $this;
}
public function getDisponible(): ?bool
{
    return $this->Disponible;

}
public function setDisponible(bool $Disponible): static
{
    $this->Disponible = $Disponible;
    return $this;
}

public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(string $description): static
{
    $this->description = $description;
    return $this;
}
public function getCategorie(): ?Categorie
{
    return $this->Categorie;

}
public function setCategorie(Categorie $Categorie): static
{
    $this->Categorie = $Categorie;
    return $this;
}

    /**
     * @return Collection<int, Reservation>
     */

public function getTerrain(): Collection
{
    return $this->Terrain;

}
    public function addTerrain(Reservation $terrain): static
    {
        if (!$this->Terrain->contains($terrain)) {
            $this->Terrain->add($terrain);
            $terrain->setTerrain($this);
        }

        return $this;
    }

    public function removeTerrain(Reservation $terrain): static
    {
        if ($this->Terrain->removeElement($terrain)) {
            // set the owning side to null (unless already changed)
            if ($terrain->getTerrain() === $this) {
                $terrain->setTerrain(null);
            }
        }

        return $this;
    }


public function __toString(): string
{
    return $this->nomTerrain.''; // Retourne le nom complet
}




}
