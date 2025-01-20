<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_categorie = null;


    #[ORM\OneToMany(targetEntity: Terrain::class, mappedBy: 'Categorie', orphanRemoval: true)]
    private Collection $Categorie;

    public function __construct(){
        $this->Categorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): static
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    /**
     * @return Collection<int, Terrain>
     */

    public function getCategorie(): Collection
    {
        return $this->Categorie;
    }
    public function addCategorie(Terrain $categorie): static
    {
        if (!$this->Categorie->contains($categorie)) {
            $this->Categorie->add($categorie);
            $categorie->setCategorie($this);

        }
        return $this;
    }

    public function removeCategorie(Terrain $categorie): static
    {
       if ($this ->Categorie->removeElement($categorie)) {
           // set the owning side to null (unless already changed)
           if ($categorie->getCategorie() === $this) {
               $categorie->setCategorie(null);
           }
       }
       return $this;
    }
    public function __toString():string
    {
        return $this->nom_categorie.'';
    }
















}
