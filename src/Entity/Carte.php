<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte extends Jeu
{
    #[ORM\Column(nullable: true, type: Types::SMALLINT)]
    private ?int $nbCarte = null;

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
