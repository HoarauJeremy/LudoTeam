<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbCarte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbCarte(): ?int
    {
        return $this->nbCarte;
    }

    public function setNbCarte(?int $nbCarte): static
    {
        $this->nbCarte = $nbCarte;

        return $this;
    }
}
