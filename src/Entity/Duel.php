<?php

namespace App\Entity;

use App\Repository\DuelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DuelRepository::class)]
class Duel
{
    #[ORM\Column(nullable: true)]
    private ?bool $duel = null;

    public function isDuel(): ?bool
    {
        return $this->duel;
    }

    public function setDuel(?bool $duel): static
    {
        $this->duel = $duel;

        return $this;
    }
}
