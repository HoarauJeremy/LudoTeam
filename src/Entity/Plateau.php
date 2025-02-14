<?php

namespace App\Entity;

use App\Repository\PlateauRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateauRepository::class)]
class Plateau extends Jeu
{

    #[ORM\Column(nullable: true, type: Types::SMALLINT)]
    private ?int $nbDes = null;

    public function getNbDes(): ?int
    {
        return $this->nbDes;
    }

    public function setNbDes(?int $nbDes): static
    {
        $this->nbDes = $nbDes;

        return $this;
    }
}
