<?php

namespace App\Entity;

use App\Repository\PlateauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateauRepository::class)]
class Plateau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbDes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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
