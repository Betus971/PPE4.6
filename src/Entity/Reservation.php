<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThanOrEqual('today UTC')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'Terrain')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Terrain $Terrain = null;

    #[ORM\ManyToOne(inversedBy: 'User')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datefin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   public function getDateCreation(): ?\DateTimeInterface
   {
       return $this->dateCreation;

   }

   public function setDateCreation(\DateTimeInterface $dateCreation): static
   {
       $this->dateCreation = $dateCreation;
       return $this;
   }

public function getTerrain(): ?Terrain
{
    return $this->Terrain;
}
public function setTerrain(?Terrain $Terrain): static
{
    $this->Terrain = $Terrain;
    return $this;
}

public function getUser(): ?User
{
    return $this->User;
}
public function setUser(?User $User): static
{
    $this->User = $User;
    return $this;
}

public function getDatefin(): ?\DateTimeInterface
{
    return $this->datefin;
}

public function setDatefin(\DateTimeInterface $datefin): static
{
    $this->datefin = $datefin;
    return $this;
}



}
